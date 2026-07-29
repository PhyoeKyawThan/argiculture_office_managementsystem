<!DOCTYPE html>
<html lang="en">
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
    <h1>Agriculture Office Report</h1>
    <div class="meta">
        <strong>Date Range:</strong> {{ $dateFrom }} to {{ $dateTo }}<br>
        <strong>Generated:</strong> {{ now()->format('Y-m-d H:i:s') }}
    </div>

    @if(in_array('fertilizer_licenses', $topics))
        <h2>Fertilizer Distribution Licenses</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Applicant Name</th>
                    <th>Shop Name</th>
                    <th>NRC Number</th>
                    <th>Township</th>
                    <th>Application Date</th>
                    <th>Status</th>
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
                        <td>{{ ucfirst($license->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center; color:#6b7280;">No records found</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('pesticide_shops', $topics))
        <h2>Pesticide Shop Registrations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>NRC</th>
                    <th>Township</th>
                    <th>Shop Address</th>
                    <th>Building Type</th>
                    <th>Business Type</th>
                    <th>Status</th>
                    <th>Applied At</th>
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
                        <td>{{ $shop->retail_or_wholesale === 'retail' ? 'Retail' : 'Wholesale' }}</td>
                        <td>{{ ucfirst($shop->status) }}</td>
                        <td>{{ $shop->created_at?->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="9" style="text-align:center; color:#6b7280;">No records found</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    @if(in_array('inspections', $topics))
        <h2>Pesticide Shop Inspections</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Owner Name</th>
                    <th>Shop Address</th>
                    <th>Township</th>
                    <th>Inspection Date</th>
                    <th>Valid Retail License</th>
                    <th>Complies With Law</th>
                    <th>Training Certificate</th>
                    <th>Action Taken</th>
                    <th>Remarks</th>
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
                        <td>{{ $inspection->has_valid_retail_license ? 'Yes' : 'No' }}</td>
                        <td>{{ $inspection->complies_with_pesticide_law ? 'Yes' : 'No' }}</td>
                        <td>{{ $inspection->has_training_certificate ? 'Yes' : 'No' }}</td>
                        <td>{{ $inspection->action_taken }}</td>
                        <td>{{ $inspection->remarks }}</td>
                    </tr>
                @empty
                    <tr><td colspan="10" style="text-align:center; color:#6b7280;">No records found</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    <div class="footer">
        Agriculture Office Management System &middot; Generated on {{ now()->format('Y-m-d H:i:s') }}
    </div>
</body>
</html>
