@extends('admin.layouts.root')

@section('title', 'Fertilizer Licenses')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-emerald-900">Fertilizer Licenses</h1>
            <p class="text-slate-600 text-sm mt-1">Review applications and update transfer status.</p>
        </div>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search applicant, shop, or NRC"
            class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none min-w-[220px] flex-1">
        <select name="status" class="rounded-xl border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
            <option value="">All statuses</option>
            @foreach(\App\Models\FertilizerDistributionLicense::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-emerald-100 text-emerald-900 font-bold rounded-xl text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-2xl border border-emerald-100 overflow-hidden shadow-sm overflow-x-auto">
        <table class="w-full text-sm min-w-[1100px]">
            <thead class="bg-emerald-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-bold text-emerald-900">Applicant</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">Shop</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">NRC</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">Application Date</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">Items</th>
                    <th class="px-4 py-3 font-bold text-emerald-900">Status</th>
                    <th class="px-4 py-3 font-bold text-emerald-900 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                @forelse($licenses as $license)
                    <tr class="hover:bg-emerald-50/50">
                        <td class="px-4 py-4">
                            <div class="font-semibold text-slate-900">{{ $license->applicant_name }}</div>
                            <div class="text-xs text-slate-500">{{ $license->user?->email ?? 'Guest application' }}</div>
                        </td>
                        <td class="px-4 py-4 text-slate-700">{{ $license->shop_name ?? '—' }}</td>
                        <td class="px-4 py-4 text-slate-700">{{ $license->nrc_number }}</td>
                        <td class="px-4 py-4 text-slate-700 whitespace-nowrap">{{ $license->application_date?->format('M j, Y') ?? '—' }}</td>
                        <td class="px-4 py-4">
                            <div class="font-semibold text-slate-900">{{ $license->items->count() }}</div>
                            <div class="text-xs text-slate-500">{{ $license->items->pluck('fertilizer_name')->take(2)->implode(', ') ?: 'No items' }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-black uppercase tracking-wider
                                {{ $license->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($license->status === 'sending_to_regional_department' ? 'bg-blue-100 text-blue-800' : ($license->status === 'allowed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800')) }}">
                                {{ ucfirst(str_replace('_', ' ', $license->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-right space-y-2 whitespace-nowrap">
                            <a href="{{ route('admin.fertilizer-licenses.show', $license) }}" class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200">
                                View Details
                            </a>
                            @if($license->isTransferable())
                                <form action="{{ route('admin.fertilizer-licenses.update_status', $license) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="sending_to_regional_department">
                                    <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-700 text-white font-bold hover:bg-emerald-800">
                                        Transfer to Regional Department
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.fertilizer-licenses.update_status', $license) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <select name="status" class="rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 outline-none">
                                    @foreach(\App\Models\FertilizerDistributionLicense::STATUSES as $status)
                                        <option value="{{ $status }}" @selected($license->status === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="px-3 py-2 rounded-xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50">Update</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-500">No fertilizer license applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $licenses->links() }}</div>
@endsection