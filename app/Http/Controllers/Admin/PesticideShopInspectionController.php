<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePesticideShopInspectionRequest;
use App\Http\Requests\Admin\UpdatePesticideShopInspectionRequest;
use App\Models\PesticideShopInspection;
use App\Models\Staff;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PesticideShopInspectionController extends Controller
{
    public function index(Request $request): View
    {
        $inspections = PesticideShopInspection::query()
            ->with('inspector:id,name,personal_no')
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . $request->string('search') . '%';
                $query->where('owner_name', 'like', $term);
            })
            ->when($request->filled('township'), fn ($query) => $query->where('township', $request->string('township')))
            ->orderByDesc('inspection_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $townships = PesticideShopInspection::query()
            ->distinct()
            ->orderBy('township')
            ->pluck('township');

        return view('admin.pesticide-shop-inspections.index', compact('inspections', 'townships'));
    }

    public function create(): View
    {
        return view('admin.pesticide-shop-inspections.create', [
            'inspectors' => Staff::query()->orderBy('name')->get(['id', 'name']),
            'defaultInspectorId' => auth()->user()?->staff_id,
        ]);
    }

    public function store(StorePesticideShopInspectionRequest $request): RedirectResponse
    {
        $data = $this->payloadFromRequest($request);

        $inspection = DB::transaction(fn () => PesticideShopInspection::create($data));

        return redirect()
            ->route('admin.pesticide-shop-inspections.show', $inspection)
            ->with('success', __('messages.flash.inspection_created'));
    }

    public function show(PesticideShopInspection $pesticide_shop_inspection): View
    {
        $pesticide_shop_inspection->load('inspector:id,name,personal_no,current_office');

        return view('admin.pesticide-shop-inspections.show', [
            'inspection' => $pesticide_shop_inspection,
        ]);
    }

    public function edit(PesticideShopInspection $pesticide_shop_inspection): View
    {
        return view('admin.pesticide-shop-inspections.edit', [
            'inspection' => $pesticide_shop_inspection,
            'inspectors' => Staff::query()->orderBy('name')->get(['id', 'name']),
            'defaultInspectorId' => auth()->user()?->staff_id,
        ]);
    }

    public function update(UpdatePesticideShopInspectionRequest $request, PesticideShopInspection $pesticide_shop_inspection): RedirectResponse
    {
        $data = $this->payloadFromRequest($request);

        DB::transaction(fn () => $pesticide_shop_inspection->update($data));

        return redirect()
            ->route('admin.pesticide-shop-inspections.show', $pesticide_shop_inspection)
            ->with('success', __('messages.flash.inspection_updated'));
    }

    public function destroy(PesticideShopInspection $pesticide_shop_inspection): RedirectResponse
    {
        try {
            $pesticide_shop_inspection->delete();
        } catch (QueryException) {
            return back()->with('error', __('messages.inspections.delete_constraint'));
        }

        return redirect()
            ->route('admin.pesticide-shop-inspections.index')
            ->with('success', __('messages.flash.inspection_deleted'));
    }

    private function payloadFromRequest(StorePesticideShopInspectionRequest|UpdatePesticideShopInspectionRequest $request): array
    {
        $data = $request->validated();
        $data['inspector_staff_id'] = $this->resolveInspectorStaffId($request);

        if (! $data['has_valid_retail_license']) {
            $data['license_expiry_date'] = null;
        }

        return $data;
    }

    private function resolveInspectorStaffId(Request $request): string
    {
        if ($request->filled('inspector_staff_id')) {
            return $request->string('inspector_staff_id');
        }

        $staffId = auth()->user()?->staff_id;

        if ($staffId) {
            return $staffId;
        }

        throw ValidationException::withMessages([
            'inspector_staff_id' => __('messages.inspections.inspector_required'),
        ]);
    }
}
