<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReplyAgriculturalInquiryRequest;
use App\Models\AgriculturalInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AgriculturalInquiryController extends Controller
{
    public function index(Request $request): View
    {
        $inquiries = AgriculturalInquiry::query()
            ->with(['farmer:id,name,email', 'responder:id,name'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%'.$request->string('search').'%';
                $query->where(function ($inner) use ($term) {
                    $inner->where('title', 'like', $term)
                        ->orWhere('description', 'like', $term)
                        ->orWhereHas('farmer', fn ($farmer) => $farmer->where('name', 'like', $term));
                });
            })
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $pendingCount = AgriculturalInquiry::pending()->count();

        return view('admin.inquiries.index', compact('inquiries', 'pendingCount'));
    }

    public function show(Request $request, AgriculturalInquiry $inquiry): View
    {
        $inquiry->load(['farmer:id,name,email', 'responder:id,name']);

        $request->user()->unreadNotifications()
            ->where('data->inquiry_id', $inquiry->id)
            ->update(['read_at' => now()]);

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(ReplyAgriculturalInquiryRequest $request, AgriculturalInquiry $inquiry): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($inquiry, $data, $request) {
            $inquiry->answer_body = $data['answer_body'];
            $inquiry->status = $data['status'];

            if ($data['status'] === AgriculturalInquiry::STATUS_ANSWERED) {
                $inquiry->answered_by = $request->user()->id;
                $inquiry->answered_at = now();
            } else {
                $inquiry->answered_by = null;
                $inquiry->answered_at = null;
            }

            $inquiry->save();
        });

        return redirect()
            ->route('admin.inquiries.show', $inquiry)
            ->with('success', __('messages.flash.inquiry_replied'));
    }
}
