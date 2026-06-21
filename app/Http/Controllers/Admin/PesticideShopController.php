<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewPesticideShopRequest;
use App\Models\PesticideShop;
use App\Models\PesticideShopLicense;
use App\Models\PesticideShopsLicense;
use App\Models\User;
use App\Traits\DateConverterTrait;
use App\Traits\DocxProcessorTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    use DateConverterTrait;
    public function index(Request $request): View
    {
        $shops = PesticideShop::query()
            ->with(['user:id,name,email', 'reviewer:id,name'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . $request->string('search') . '%';
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

    public function update_status(PesticideShop $shop, ReviewPesticideShopRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $status = $validated['status'];
        $updatePayload = [
            'status' => $status,
        ];

        if ($status === 'rejected') {
            $updatePayload['rejection_reason'] = $validated['rejection_reason'];
        } else {
            $updatePayload['rejection_reason'] = null;
        }
        $updatePayload['reviewed_by'] = auth()->id();
        $shop->update($updatePayload);
        if($status === 'approved') {
            if($shop->license) {
                $shop->license->update([
                    'issued_date' => now(),
                    'expiry_date' => now()->addYear(),
                    'issued_by_user_id' => auth()->id(),
                ]);
            } else {
                PesticideShopsLicense::create([
                    'pesticide_shop_id' => $shop->id,
                    'license_number' => 'LIC-' . Str::upper(Str::random(8)),
                    'name' => $shop->name,
                    'nrc' => $shop->nrc,
                    'shop_address' => $shop->requested_selling_address,
                    'issued_date' => now(),
                    'expiry_date' => now()->addYear()->addYear(),
                    'issued_by_user_id' => auth()->id(),
                ]);
            }
        }
        return redirect()
            ->back()
            ->with('success', __('Application status has been updated successfully.'));
    }

    public function downloadLicense(Request $request, PesticideShop $shop)
    {
        if ($shop->status !== PesticideShop::STATUS_APPROVED) {
            return redirect()->back()->with('error', 'Only approved shops can download the license.');
        }
        $license = $shop->license;
        $textReplacements = [
            'license_number' => $license->license_number,
            'name' => $license->name,
            'nrc' => $license->nrc,
            'shop_address' => $license->shop_address,
            'issued_date' => $this->convertToBurmeseDate($license->issued_date),
            'expiry_date' => $this->convertToBurmeseDate($license->expiry_date),
        ];

        $imageReplacements = [
            // 'signature' => $shop->signature,
        ];

        $templatePath = 'templates/license.docx';

        try {
            $filePath = $this->generatePurePhpPdf($templatePath, $textReplacements, $imageReplacements);

            return response()
                ->download($filePath, "လိုင်စင်-{$shop->name}.pdf", [
                    'Content-Type' => 'application/pdf'
                ])
                ->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Document compilation failed: ' . $e->getMessage());
        }
    }
    public function downloadDocument(Request $request, $id)
    {
        $shop = PesticideShop::findOrFail($id);
        $requestedFormat = $request->query('format', 'pdf');

        $textReplacements = [
            'date' => $this->convertToBurmeseDate($shop->created_at),
            'township' => $shop->township,
            'name' => $shop->name,
            'nrc' => $shop->nrc,
            'education' => $shop->education,
            'stable_address' => $shop->stable_address,
            'requested_selling_address' => $shop->requested_selling_address,
            'building_type' => $shop->building_type,
            'building_area' => $shop->building_area,
            'has_emergency_preparedness_plan' => $shop->has_emergency_preparedness_plan ? 'ရှိ' : 'မရှိ',
            'from_restaurant_distance' => $shop->from_restaurant_distance,
            'retail_or_wholesale' => $shop->retail_or_wholesale === 'retail' ? 'လက်လီ' : 'လက်ကား',
        ];

        $imageReplacements = [
            'signature' => $shop->signature,
        ];

        $templatePath = 'templates/application_form_1.docx';

        try {
            if ($requestedFormat === 'docx') {
                $filePath = $this->generatePurePhpDocx($templatePath, $textReplacements, $imageReplacements);

                return response()
                    ->download($filePath, "လိုင်စင်လျှောက်လွှာ-{$shop->name}.docx")
                    ->deleteFileAfterSend(true);
            }
            $filePath = $this->generatePurePhpPdf($templatePath, $textReplacements, $imageReplacements);

            return response()
                ->download($filePath, "လိုင်စင်လျှောက်လွှာ-{$shop->name}.pdf", [
                    'Content-Type' => 'application/pdf'
                ])
                ->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Document compilation failed: ' . $e->getMessage());
        }
    }

    public function downloadSurroundingAgreements(Request $request, PesticideShop $shop)
    {
        $agreements = $shop->surrounding_agreements;
        $boundaries = $agreements['boundaries'] ?? [];
        $location = $agreements['location'] ?? [];
        $requestedFormat = $request->query('format', 'pdf');
        $textReplacements = [
            'gender' => $agreements['gender'] ?? '',
            'name' => $shop->name ?? '',
            'nrc' => $shop->nrc ?? '',
            'village' => $location['village'] ?? '',
            'township' => $location['township'] ?? '',
            // 'region_state' => $location['region_state'] ?? '',
            'village_tract' => $location['village_tract'] ?? '',
            'name_north' => $boundaries['store_north']['name'] ?? '',
            'nrc_north' => $boundaries['store_north']['nrc'] ?? '',
            'name_south' => $boundaries['store_south']['name'] ?? '',
            'nrc_south' => $boundaries['store_south']['nrc'] ?? '',
            'name_front' => $boundaries['store_front']['name'] ?? '',
            'nrc_front' => $boundaries['store_front']['nrc'] ?? '',
            'name_end' => $boundaries['store_end']['name'] ?? '',
            'nrc_end' => $boundaries['store_end']['nrc'] ?? '',
        ];
        // dd($textReplacements);

        $imageReplacements = [
            // 'signature' => $shop->signature,
            'signature_north' => $boundaries['store_north']['signature'] ?? null,
            'signature_south' => $boundaries['store_south']['signature'] ?? null,
            'signature_front' => $boundaries['store_front']['signature'] ?? null,
            'signature_end' => $boundaries['store_end']['signature'] ?? null,
        ];

        $templatePath = 'templates/sorrounding_agreement.docx';

        try {
            if ($requestedFormat === 'docx') {
                $filePath = $this->generatePurePhpDocx($templatePath, $textReplacements, $imageReplacements);

                return response()
                    ->download($filePath, "surrounding-agreement-{$shop->name}.docx")
                    ->deleteFileAfterSend(true);
            }
            $filePath = $this->generatePurePhpPdf($templatePath, $textReplacements, $imageReplacements);

            return response()
                ->download($filePath, "surrounding-agreement-{$shop->name}.pdf", [
                    'Content-Type' => 'application/pdf'
                ])
                ->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Document compilation failed: ' . $e->getMessage());
        }
    }
}
