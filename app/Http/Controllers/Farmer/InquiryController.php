<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Farmer\StoreAgriculturalInquiryRequest;
use App\Models\AgriculturalInquiry;
use App\Models\User;
use App\Notifications\NewFarmerInquiryNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $inquiries = AgriculturalInquiry::query()
            ->where('user_id', $request->user()->id)
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('farmer.inquiries.index', compact('inquiries'));
    }

    public function create(): View
    {
        return view('farmer.inquiries.create');
    }

    public function store(StoreAgriculturalInquiryRequest $request): RedirectResponse
    {
        $data = $request->safe()->only(['title', 'description']);
        $data['user_id'] = $request->user()->id;
        $data['status'] = AgriculturalInquiry::STATUS_PENDING;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $data['attachment_path'] = $file->store('inquiries', 'public');
            $data['attachment_original_name'] = $file->getClientOriginalName();
        }

        $inquiry = AgriculturalInquiry::create($data);

        $backOfficeUsers = User::query()
            ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
            ->get();

        Notification::send($backOfficeUsers, new NewFarmerInquiryNotification($inquiry));

        return redirect()
            ->route('farmer.inquiries.show', $inquiry)
            ->with('success', __('messages.flash.inquiry_created'));
    }

    public function show(Request $request, AgriculturalInquiry $inquiry): View
    {
        abort_unless($inquiry->user_id === $request->user()->id, 403);

        $inquiry->load('responder:id,name');

        return view('farmer.inquiries.show', compact('inquiry'));
    }
}
