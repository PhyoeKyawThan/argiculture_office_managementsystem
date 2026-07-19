<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateFertilizerLicenseStatusRequest;
use App\Models\FertilizerDistributionLicense;
use App\Notifications\LicenseStatusUpdatedNotification;
use App\Traits\DocxProcessorTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FertilizerLicenseController extends Controller
{
    use DocxProcessorTrait;
    public function index(Request $request): View
    {
        $licenses = FertilizerDistributionLicense::query()
            ->with(['user:id,name,email', 'items'])
            ->when($request->filled('status'), fn($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . $request->string('search') . '%';

                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('applicant_name', 'like', $term)
                        ->orWhere('shop_name', 'like', $term)
                        ->orWhere('nrc_number', 'like', $term);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.fertilizer-licenses.index', compact('licenses'));
    }

    public function show(FertilizerDistributionLicense $fertilizer_license): View
    {
        $fertilizer_license->load(['user:id,name,email', 'items']);
        return view('admin.fertilizer-licenses.show', [
            'license' => $fertilizer_license,
        ]);
    }

    public function generateDocx(FertilizerDistributionLicense $fertilizer_license, Request $request)
    {
        $fertilizer_license->load(['user:id,name,email', 'items']);
        $requestedFormat = $request->query('format', 'pdf');
        $date_data_mm = DateHelper::getMyanmarFormattedDate($fertilizer_license->application_date);
        $letter_no_test = 129;
        $application_letter_no = 123;
        $textReplacements = [
            'first_page_letter_no' => 'မသခ / လိုင်စင်သစ် / ' . $date_data_mm['year'] . '( ' . $letter_no_test . ' )',
            'first_page_date' => $date_data_mm['year'] . ' ခုနှစ် ၊ ' . $date_data_mm['month_text'] . 'လ (' . $date_data_mm['day'] . ') ရက်',
            'first_page_township' => $fertilizer_license->township,
            'first_page_date_dot' => implode('.', [$date_data_mm['day'], $date_data_mm['month'], $date_data_mm['year']]),
            'letter_no' => $application_letter_no,
            'applicant_name' => $fertilizer_license->applicant_name,
            // 'letter_no' => $fertilizer_license->application_date,
            'application_date' => $date_data_mm['year'] . ' ခုနှစ် ၊ ' . $date_data_mm['month_text'] . 'လ (' . $date_data_mm['day'] . ') ရက်',
            'township' => $fertilizer_license->township,
            'current_year_range' => $date_data_mm['year_range'],
            'month_in_text' => $date_data_mm['month_text'],
            // 'applicant_name' => $fertilizer_license->applicant_name,
            'permanent_address' => $fertilizer_license->permanent_address,
            'date_dot' => implode('.', [$date_data_mm['day'], $date_data_mm['month'], $date_data_mm['year']]),
            // 'applicant_name' => $fertilizer_license->applicant_name,
            'shop_name' => $fertilizer_license->shop_name,
            'nrc' => $fertilizer_license->nrc,
            'education_level' => $fertilizer_license->education_level,
            'work_experience' => $fertilizer_license->work_experience ? 'ရှိ' : 'မရှိ',
            // 'permanent_address' => $fertilizer_license->permanent_address,
            'distribution_location_address' => $fertilizer_license->distribution_location_address,
            'building_type' => $fertilizer_license->building_type,
            'building_dimensions' => $fertilizer_license->building_dimensions,
        ];
        $tableData = [
            'row_no' => []
        ];

        foreach ($fertilizer_license->items as $index => $item) {
            $tableData['row_no'][] = [
                'row_no' => DateHelper::convertToMyanmarNumber((string) ($index + 1)),
                'fertilizer_name' => $item->fertilizer_name,
                'chemical_formula' => $item->chemical_formula ?? '-',
                'fertilizer_type' => $item->fertilizer_type ?? '-',
                'packaging_material' => $item->packaging_size ?? '-',
                'weight_volume' => $item->weight_volume ?? '-',
            ];
        }
        $imageReplacements = [
            'nrc_front' => $fertilizer_license->attachment_nrc['front'] ?? null,
            'nrc_end' => $fertilizer_license->attachment_nrc['back'] ?? null,
        ];
        // dd($imageReplacements);
        $templatePath = 'templates/fertilizer_application.docx';
        try {
            if ($requestedFormat === 'docx') {
                $filePath = $this->generatePurePhpDocx(
                    $templatePath,
                    $textReplacements,
                    $imageReplacements,
                    $tableData,
                    imageDimensions: [
                        "width" => 600,
                        "height" => 300,
                    ]
                );
                return response()
                    ->download($filePath, "မြေသြဇာ လိုင်စင်လျှောက်လွှာ-{$fertilizer_license->shop_name}.docx")
                    ->deleteFileAfterSend(true);
            }
            $filePath = $this->generatePurePhpPdf(
                $templatePath,
                $textReplacements,
                $imageReplacements,
                $tableData,
                imageDimensions: [
                    "width" => 600,
                    "height" => 300,
                ]
            );

            return response()
                ->download($filePath, "မြေသြဇာ လိုင်စင်လျှောက်လွှာ-{$fertilizer_license->shop_name}.pdf", [
                    'Content-Type' => 'application/pdf'
                ])
                ->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Document compilation failed: ' . $e->getMessage());
        }
    }

    public function updateStatus(UpdateFertilizerLicenseStatusRequest $request, FertilizerDistributionLicense $fertilizer_license): RedirectResponse
    {
        $previousStatus = $fertilizer_license->status;
        $newStatus = $request->string('status')->toString();
        if($newStatus === FertilizerDistributionLicense::STATUS_CANCELLED){
            $fertilizer_license->update(['status' => $newStatus, 'cancelled_reason' => $request->string('cancelled_reason')]);
        } else {
            $fertilizer_license->update([
                'status' => $newStatus,
            ]);
        }

        if ($previousStatus !== $newStatus && $fertilizer_license->user) {
            $fertilizer_license->user->notify(new LicenseStatusUpdatedNotification($fertilizer_license, $previousStatus));
        }

        return back()->with('success', 'Fertilizer license status updated successfully.');
    }
}