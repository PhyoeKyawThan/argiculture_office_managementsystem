<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewPesticideShopRequest;
use App\Models\PesticideShop;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PesticideShopController extends Controller
{
    public function index(Request $request): View
    {
        $shops = PesticideShop::query()
            ->with(['user:id,name,email', 'reviewer:id,name'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%'.$request->string('search').'%';
                $query->where(function ($inner) use ($term) {
                    $inner->where('shop_name', 'like', $term)
                        ->orWhere('owner_name', 'like', $term)
                        ->orWhere('license_number', 'like', $term)
                        ->orWhere('email', 'like', $term);
                });
            })
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $pendingCount = PesticideShop::query()->where('status', PesticideShop::STATUS_PENDING)->count();

        return view('admin.pesticide-shops.index', compact('shops', 'pendingCount'));
    }

    public function show(Request $request, PesticideShop $pesticideShop): View
    {
        $pesticideShop->load(['user:id,name,email', 'reviewer:id,name']);

        $request->user()->unreadNotifications()
            ->where('data->shop_id', $pesticideShop->id)
            ->update(['read_at' => now()]);

        return view('admin.pesticide-shops.show', compact('pesticideShop'));
    }

    public function update(ReviewPesticideShopRequest $request, PesticideShop $pesticideShop): RedirectResponse
    {
        if (! $pesticideShop->isPending()) {
            return redirect()
                ->route('admin.pesticide-shops.show', $pesticideShop)
                ->with('error', __('messages.flash.shop_already_reviewed'));
        }

        $action = $request->validated('action');

        DB::transaction(function () use ($request, $pesticideShop, $action) {
            if ($action === PesticideShop::STATUS_APPROVED) {
                $user = User::create([
                    'name' => $pesticideShop->owner_name,
                    'email' => $pesticideShop->email,
                    'password' => bcrypt(Str::password(12)),
                    'role' => User::ROLE_SHOP,
                ]);

                $pesticideShop->update([
                    'user_id' => $user->id,
                    'status' => PesticideShop::STATUS_APPROVED,
                    'rejection_reason' => null,
                    'reviewed_by' => $request->user()->id,
                    'reviewed_at' => now(),
                ]);
            } else {
                $pesticideShop->update([
                    'status' => PesticideShop::STATUS_REJECTED,
                    'rejection_reason' => $request->validated('rejection_reason'),
                    'reviewed_by' => $request->user()->id,
                    'reviewed_at' => now(),
                ]);
            }
        });

        $message = $action === PesticideShop::STATUS_APPROVED
            ? __('messages.flash.shop_approved')
            : __('messages.flash.shop_rejected');

        return redirect()
            ->route('admin.pesticide-shops.show', $pesticideShop)
            ->with('success', $message);
    }
}
