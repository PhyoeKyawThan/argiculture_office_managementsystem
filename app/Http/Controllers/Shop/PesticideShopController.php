<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewPesticideShopRequest;
use App\Models\PesticideShop;
use App\Models\User;
use App\Notifications\NewShopRegistrationNotification;
use App\Notifications\UpdateShopRegistrationNotification;
use App\Traits\DocxProcessorTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Http\Requests\Shop\StorePesticideShopRequest;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Http\Requests\Shop\UpdatePesticideShopRequest;

class PesticideShopController extends Controller
{
    use DocxProcessorTrait;

    public function licenseRegisterationForm(PesticideShop $pesticideShop): View
    {
        $nrc_formats = config('app.nrc_formats');
        $nrc_formats = get_formatted_nrc_suits($nrc_formats);
        return view('shop.forms.license-register', compact('pesticideShop', 'nrc_formats'));
    }

    public function store(StorePesticideShopRequest $request)
    {
        try {
            $attachmentPaths = [];
            $agreementData = $request->input('surrounding_agreements');
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $key => $file) {
                    //storage/app/public/pesticide_shops/attachments/
                    $path = $file->store('pesticide_shops/attachments', 'public');
                    $attachmentPaths[$key] = $path;
                }
            }

            if ($request->hasFile('surrounding_agreements_signatures')) {
                foreach ($request->file('surrounding_agreements_signatures') as $direction => $file) {
                    // storage/app/public/pesticide_shops/signatures/
                    $path = $file->store('pesticide_shops/signatures', 'public');
                    $agreementData['boundaries'][$direction]['signature'] = $path;
                }
            }
            $mainSignaturePath = null;
            if ($request->hasFile('signature')) {
                $mainSignaturePath = $request->file('signature')->store('pesticide_shops/signatures/applicant', 'public');
            }
            $pesticideShop = PesticideShop::create([
                'user_id' => auth()->id(),
                'name' => $request->input('name'),
                'township' => $request->input('township'),
                'nrc' => $request->input('nrc'),
                'education' => $request->input('education'),
                'stable_address' => $request->input('stable_address'),
                'requested_selling_address' => $request->input('requested_selling_address'),
                'building_type' => $request->input('building_type'),
                'building_area' => $request->input('building_area'),
                'from_restaurant_distance' => $request->input('from_restaurant_distance'),
                'retail_or_wholesale' => $request->input('retail_or_wholesale'),
                'has_emergency_preparedness_plan' => $request->boolean('has_emergency_preparedness_plan'),
                'signature' => $mainSignaturePath,
                'attachments' => $attachmentPaths,
                'surrounding_agreements' => $agreementData,
                'status' => 'pending',
                'created_at' => $request->input('created_at'),
            ]);
            $backOfficeUsers = User::query()
                ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
                ->get();

            Notification::send($backOfficeUsers, new NewShopRegistrationNotification($pesticideShop));
            return redirect()
                ->route('shop.dashboard')
                ->with('success', 'Application submitted successfully to the Agriculture Office!');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Something went wrong while processing data: ' . $e->getMessage()]);
        }
    }

    public function licenseEditForm($id)
    {
        $pesticideShop = PesticideShop::findOrFail($id);
        if ($pesticideShop->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($pesticideShop->status === 'approved') {
            return redirect()
                ->route('shop.dashboard')
                ->with('error', 'Approved applications cannot be modified.');
        }
        $attachments = $pesticideShop->attachments ?? [];
        $surroundingAgreements = $pesticideShop->surrounding_agreements ?? [];

        $nrc_formats = config('app.nrc_formats');
        $nrc_formats = get_formatted_nrc_suits($nrc_formats);
        $nrcState = '၁၂';
        $nrcDistrict = '';
        $nrcNaing = 'နိုင်';
        $nrcSerial = '';

        if (!empty($pesticideShop->nrc)) {
            preg_match('/^([၁-၉]|၁[၀-၄])\/([^\s\(\)]+)\((နိုင်|ပြု|ဧည့်|သာ)\)([၀-၉]+)$/u', $pesticideShop->nrc, $matches);
            if (count($matches) === 5) {
                $nrcState = $matches[1];
                $nrcDistrict = $matches[2];
                $nrcNaing = $matches[3];
                $nrcSerial = $matches[4];
            }
            if (!empty($nrcDistrict)) {
                foreach ($nrc_formats['districts'] as $district) {
                    if (str_contains($district['name_mm'], $nrcDistrict)) {
                        $nrcDistrict = $district['name_mm'];
                        break;
                    }
                }
            }
        }
        return view('shop.forms.license-edit', compact(
            'pesticideShop',
            'attachments',
            'surroundingAgreements',
            'nrc_formats',
            'nrcState',
            'nrcDistrict',
            'nrcNaing',
            'nrcSerial'
        ));
    }
    public function update(UpdatePesticideShopRequest $request, $id)
    {
        $pesticideShop = PesticideShop::findOrFail($id);
        $validated = $request->validated();
        $updateData = [
            'name' => $validated['name'],
            'township' => $validated['township'],
            'nrc' => $validated['nrc'],
            'education' => $validated['education'],
            'stable_address' => $validated['stable_address'],
            'requested_selling_address' => $validated['requested_selling_address'],
            'building_type' => $validated['building_type'],
            'building_area' => $validated['building_area'],
            'from_restaurant_distance' => $validated['from_restaurant_distance'],
            'retail_or_wholesale' => $validated['retail_or_wholesale'],
            'has_emergency_preparedness_plan' => $request->has('has_emergency_preparedness_plan') ? 1 : 0,
            'status' => 'pending',
            'created_at' => $validated['created_at'],
        ];

        if ($request->hasFile('signature')) {
            if ($pesticideShop->signature) {
                Storage::disk('public')->delete($pesticideShop->signature);
            }
            $updateData['signature'] = $request->file('signature')->store('pesticide_shops/signatures/applicant', 'public');
        }

        $currentAttachments = $pesticideShop->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $key => $file) {
                if (isset($currentAttachments[$key])) {
                    Storage::disk('public')->delete($currentAttachments[$key]);
                }
                $currentAttachments[$key] = $file->store('pesticide_shops/attachments', 'public');
            }
        }
        $updateData['attachments'] = $currentAttachments;

        $agreements = $validated['surrounding_agreements'];
        $oldAgreements = $pesticideShop->surrounding_agreements ?? [];

        foreach (['store_front', 'store_end', 'store_south', 'store_north'] as $direction) {
            $existingSignaturePath = data_get($oldAgreements, "boundaries.{$direction}.signature");

            if ($request->hasFile("surrounding_agreements_signatures.{$direction}")) {
                if ($existingSignaturePath) {
                    Storage::disk('public')->delete($existingSignaturePath);
                }
                $file = $request->file("surrounding_agreements_signatures.{$direction}");
                $existingSignaturePath = $file->store('pesticide_shops/signatures/neighbors', 'public');
            }

            $agreements['boundaries'][$direction]['signature'] = $existingSignaturePath;
        }
        $updateData['surrounding_agreements'] = $agreements;
        $pesticideShop->update($updateData);

        $backOfficeUsers = User::query()
            ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
            ->get();
        Notification::send($backOfficeUsers, new UpdateShopRegistrationNotification($pesticideShop));
        return redirect()
            ->route('shop.dashboard')
            ->with('success', 'လိုင်စင်လျှောက်လွှာ အချက်အလက်များကို အောင်မြင်စွာ ပြင်ဆင်ပြီးပါပြီ။');
    }
}
