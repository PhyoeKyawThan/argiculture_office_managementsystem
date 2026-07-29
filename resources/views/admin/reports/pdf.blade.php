<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'pyidaungsu', sans-serif; font-size: 11pt; color: #1f2937; }
        h1 { font-size: 16pt; margin-bottom: 4px; }
        h2 { font-size: 13pt; margin-top: 18px; margin-bottom: 6px; color: #065f46; border-bottom: 1px solid #d1fae5; padding-bottom: 4px; }
        .meta { font-size: 10pt; color: #4b5563; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        th { background: #ecfdf5; color: #064e3b; font-weight: 700; text-align: left; padding: 6px 8px; border: 1px solid #d1fae5; }
        td { padding: 6px 8px; border: 1px solid #e5e7eb; }
        tr:nth-child(even) { background: #f9fafb; }
        .footer { font-size: 9pt; color: #6b7280; margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <h1>{{ __('messages.reports.pdf_title') }}</h1>
    <div class="meta">
        <strong>{{ __('messages.reports.date_range') }}</strong> {{ $dateFrom }} to {{ $dateTo }}<br>
        <strong>{{ __('messages.reports.generated') }}</strong> {{ now()->format('Y-m-d H:i:s') }}
    </div>

    @if(in_array('fertilizer_licenses', $topics))
        <h2>{{ __('messages.reports.sections.fertilizer_licenses') }}</h2>
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.reports.columns.fertilizer.id') }}</th>
                    <th>{{ __('messages.reports.columns.fertilizer.applicant_name') }}</th>
                    <th>{{ __('messages.reports.columns.fertilizer.shop_name') }}</th>
                    <th>{{ __('messages.reports.columns.fertilizer.nrc_number') }}</th>
                    <th>{{ __('messages.reports.columns.fertilizer.township') }}</th>
                    <th>{{ __('messages.reports.columns.fertilizer.application_date') }}</th>
                    <th>{{ __('messages.reports.columns.fertilizer.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $licenses = \App\Models\FertilizerDistributionLicense::query()
                        ->whereBetween('application_date', [$dateFrom, $dateTo])
                        ->orderBy('application_date')
                        ->get();
                @endphp
                @forelse($licenses as $license)
                    <tr>
                        <td>{{ $license->id }}</td>
                        <td>{{ $license->applicant_name }}</td>
                        <td>{{ $license->shop_name }}</td>
                        <td>{{ $license->nrc_number }}</td>
                        <td>{{ $license->township }}</td>
                        <td>{{ $license->application_date?->format('Y-m-d') }}</td>
                        <td>{{ __('messages.fertilizer_license.statuses.'.$license->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center; color:#6b7280;">{{ __('messages.reports.no_records') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('pesticide_shops', $topics))
        <h2>{{ __('messages.reports.sections.pesticide_shops') }}</h2>
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.reports.columns.pesticide_shops.id') }}</th>
                    <th>{{ __('messages.reports.columns.pesticide_shops.name') }}</th>
                    <th>{{ __('messages.reports.columns.pesticide_shops.nrc') }}</th>
                    <th>{{ __('messages.reports.columns.pesticide_shops.township') }}</th>
                    <th>{{ __('messages.reports.columns.pesticide_shops.shop_address') }}</th>
                    <th>{{ __('messages.reports.columns.pesticide_shops.building_type') }}</th>
                    <th>{{ __('messages.reports.columns.pesticide_shops.business_type') }}</th>
                    <th>{{ __('messages.reports.columns.pesticide_shops.status') }}</th>
                    <th>{{ __('messages.reports.columns.pesticide_shops.applied_at') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $shops = \App\Models\PesticideShop::query()
                        ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
                        ->orderBy('created_at')
                        ->get();
                @endphp
                @forelse($shops as $shop)
                    <tr>
                        <td>{{ $shop->id }}</td>
                        <td>{{ $shop->name }}</td>
                        <td>{{ $shop->nrc }}</td>
                        <td>{{ $shop->township }}</td>
                        <td>{{ $shop->requested_selling_address }}</td>
                        <td>{{ $shop->building_type }}</td>
                        <td>{{ $shop->retail_or_wholesale === 'retail' ? __('messages.common.retail') : __('messages.common.wholesale') }}</td>
                        <td>{{ ucfirst($shop->status) }}</td>
                        <td>{{ $shop->created_at?->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="9" style="text-align:center; color:#6b7280;">{{ __('messages.reports.no_records') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('inspections', $topics))
        <h2>{{ __('messages.reports.sections.inspections') }}</h2>
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.reports.columns.inspections.id') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.owner_name') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.shop_address') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.township') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.inspection_date') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.valid_retail_license') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.complies_with_law') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.training_certificate') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.action_taken') }}</th>
                    <th>{{ __('messages.reports.columns.inspections.remarks') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $inspections = \App\Models\PesticideShopInspection::query()
                        ->whereBetween('inspection_date', [$dateFrom, $dateTo])
                        ->orderBy('inspection_date')
                        ->get();
                @endphp
                @forelse($inspections as $inspection)
                    <tr>
                        <td>{{ $inspection->id }}</td>
                        <td>{{ $inspection->owner_name }}</td>
                        <td>{{ $inspection->shop_address }}</td>
                        <td>{{ $inspection->township }}</td>
                        <td>{{ $inspection->inspection_date?->format('Y-m-d') }}</td>
                        <td>{{ $inspection->has_valid_retail_license ? __('messages.common.yes') : __('messages.common.no') }}</td>
                        <td>{{ $inspection->complies_with_pesticide_law ? __('messages.common.yes') : __('messages.common.no') }}</td>
                        <td>{{ $inspection->has_training_certificate ? __('messages.common.yes') : __('messages.common.no') }}</td>
                        <td>{{ $inspection->action_taken }}</td>
                        <td>{{ $inspection->remarks }}</td>
                    </tr>
                @empty
                    <tr><td colspan="10" style="text-align:center; color:#6b7280;">{{ __('messages.reports.no_records') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <div class="footer">
        {{ __('messages.reports.footer', ['date' => now()->format('Y-m-d H:i:s')]) }}
    </div>
</body>
</html>
