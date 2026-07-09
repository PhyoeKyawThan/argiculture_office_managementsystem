<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $latestFertilizerLicense = auth()->user()
            ?->fertilizerDistributionLicenses()
            ->with('items')
            ->latest()
            ->first();

        return view('shop.dashboard', compact('latestFertilizerLicense'));
    }
}
