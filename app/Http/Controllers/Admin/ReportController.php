<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FertilizerDistributionLicense;
use App\Models\PesticideShop;
use App\Models\PesticideShopInspection;
use Illuminate\Http\Request;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function export(Request $request)
    {
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'topics' => 'required|array|min:1',
            'topics.*' => 'in:fertilizer_licenses,pesticide_shops,inspections',
            'format' => 'required|in:pdf,csv',
        ]);

        $dateFrom = $request->string('date_from');
        $dateTo = $request->string('date_to');
        $topics = $request->array('topics');
        $format = $request->input('format');

        if ($format === 'pdf') {
            return $this->exportPdf($dateFrom, $dateTo, $topics);
        }

        return $this->exportCsv($dateFrom, $dateTo, $topics);
    }

    private function exportPdf(string $dateFrom, string $dateTo, array $topics)
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                storage_path('fonts'),
            ]),
            'fontdata' => $fontData + [
                'pyidaungsu' => [
                    'R' => 'Pyidaungsu-Regular.ttf', 
                    // 'B' => 'Pyidaungsu-Bold.ttf',    
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ],
            ],
            'default_font' => 'pyidaungsu', 
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 15,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        $mpdf->SetTitle(__('messages.reports.pdf_title'));
        $mpdf->SetAuthor(__('messages.reports.pdf_author'));

        $html = view('admin.reports.pdf', compact('topics', 'dateFrom', 'dateTo'))->render();
        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');

        $fileName = 'report_' . now()->format('Ymd_His') . '.pdf';

        return Response::make($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Content-Length' => strlen($pdfContent),
        ]);
    }

    private function exportCsv(string $dateFrom, string $dateTo, array $topics)
    {
        $fileName = 'report_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($dateFrom, $dateTo, $topics) {
            $handle = fopen('php://output', 'w');

            foreach ($topics as $topic) {
                if ($topic === 'fertilizer_licenses') {
                    $this->writeFertilizerLicensesCsv($handle, $dateFrom, $dateTo);
                } elseif ($topic === 'pesticide_shops') {
                    $this->writePesticideShopsCsv($handle, $dateFrom, $dateTo);
                } elseif ($topic === 'inspections') {
                    $this->writeInspectionsCsv($handle, $dateFrom, $dateTo);
                }
            }

            fclose($handle);
        }, $fileName);
    }

    private function writeFertilizerLicensesCsv($handle, string $dateFrom, string $dateTo): void
    {
        fputcsv($handle, [__('messages.reports.sections.fertilizer_licenses')]);
        fputcsv($handle, [__('messages.reports.generated') . ' ' . now()->format('Y-m-d H:i:s')]);
        fputcsv($handle, [__('messages.reports.date_range') . ' ' . $dateFrom . ' to ' . $dateTo]);
        fputcsv($handle, []);

        fputcsv($handle, [
            __('messages.reports.columns.fertilizer.id'),
            __('messages.reports.columns.fertilizer.applicant_name'),
            __('messages.reports.columns.fertilizer.shop_name'),
            __('messages.reports.columns.fertilizer.nrc_number'),
            __('messages.reports.columns.fertilizer.township'),
            __('messages.reports.columns.fertilizer.application_date'),
            __('messages.reports.columns.fertilizer.status'),
        ]);

        FertilizerDistributionLicense::query()
            ->whereBetween('application_date', [$dateFrom, $dateTo])
            ->orderBy('application_date')
            ->chunk(200, function ($licenses) use ($handle) {
                foreach ($licenses as $license) {
                    fputcsv($handle, [
                        $license->id,
                        $license->applicant_name,
                        $license->shop_name,
                        $license->nrc_number,
                        $license->township,
                        $license->application_date?->format('Y-m-d'),
                        $license->status,
                    ]);
                }
            });

        fputcsv($handle, []);
        fputcsv($handle, []);
    }

    private function writePesticideShopsCsv($handle, string $dateFrom, string $dateTo): void
    {
        fputcsv($handle, [__('messages.reports.sections.pesticide_shops')]);
        fputcsv($handle, [__('messages.reports.generated') . ' ' . now()->format('Y-m-d H:i:s')]);
        fputcsv($handle, [__('messages.reports.date_range') . ' ' . $dateFrom . ' to ' . $dateTo]);
        fputcsv($handle, []);

        fputcsv($handle, [
            __('messages.reports.columns.pesticide_shops.id'),
            __('messages.reports.columns.pesticide_shops.name'),
            __('messages.reports.columns.pesticide_shops.nrc'),
            __('messages.reports.columns.pesticide_shops.township'),
            __('messages.reports.columns.pesticide_shops.shop_address'),
            __('messages.reports.columns.pesticide_shops.building_type'),
            __('messages.reports.columns.pesticide_shops.business_type'),
            __('messages.reports.columns.pesticide_shops.status'),
            __('messages.reports.columns.pesticide_shops.applied_at'),
        ]);

        PesticideShop::query()
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->orderBy('created_at')
            ->chunk(200, function ($shops) use ($handle) {
                foreach ($shops as $shop) {
                    fputcsv($handle, [
                        $shop->id,
                        $shop->name,
                        $shop->nrc,
                        $shop->township,
                        $shop->requested_selling_address,
                        $shop->building_type,
                        $shop->retail_or_wholesale === 'retail' ? __('messages.common.retail') : __('messages.common.wholesale'),
                        $shop->status,
                        $shop->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

        fputcsv($handle, []);
        fputcsv($handle, []);
    }

    private function writeInspectionsCsv($handle, string $dateFrom, string $dateTo): void
    {
        fputcsv($handle, [__('messages.reports.sections.inspections')]);
        fputcsv($handle, [__('messages.reports.generated') . ' ' . now()->format('Y-m-d H:i:s')]);
        fputcsv($handle, [__('messages.reports.date_range') . ' ' . $dateFrom . ' to ' . $dateTo]);
        fputcsv($handle, []);

        fputcsv($handle, [
            __('messages.reports.columns.inspections.id'),
            __('messages.reports.columns.inspections.owner_name'),
            __('messages.reports.columns.inspections.shop_address'),
            __('messages.reports.columns.inspections.township'),
            __('messages.reports.columns.inspections.inspection_date'),
            __('messages.reports.columns.inspections.valid_retail_license'),
            __('messages.reports.columns.inspections.complies_with_law'),
            __('messages.reports.columns.inspections.training_certificate'),
            __('messages.reports.columns.inspections.action_taken'),
            __('messages.reports.columns.inspections.remarks'),
        ]);

        PesticideShopInspection::query()
            ->whereBetween('inspection_date', [$dateFrom, $dateTo])
            ->orderBy('inspection_date')
            ->chunk(200, function ($inspections) use ($handle) {
                foreach ($inspections as $inspection) {
                    fputcsv($handle, [
                        $inspection->id,
                        $inspection->owner_name,
                        $inspection->shop_address,
                        $inspection->township,
                        $inspection->inspection_date?->format('Y-m-d'),
                        $inspection->has_valid_retail_license ? __('messages.common.yes') : __('messages.common.no'),
                        $inspection->complies_with_pesticide_law ? __('messages.common.yes') : __('messages.common.no'),
                        $inspection->has_training_certificate ? __('messages.common.yes') : __('messages.common.no'),
                        $inspection->action_taken,
                        $inspection->remarks,
                    ]);
                }
            });

        fputcsv($handle, []);
        fputcsv($handle, []);
    }
}
