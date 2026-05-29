<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\AgriculturalAnnouncement;
use App\Models\AgriculturalInquiry;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('farmer.dashboard', [
            'pendingCount' => AgriculturalInquiry::query()
                ->where('user_id', $user->id)
                ->pending()
                ->count(),
            'answeredCount' => AgriculturalInquiry::query()
                ->where('user_id', $user->id)
                ->answered()
                ->count(),
            'recentInquiries' => AgriculturalInquiry::query()
                ->where('user_id', $user->id)
                ->latest()
                ->limit(5)
                ->get(),
            'latestNews' => AgriculturalAnnouncement::published()
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }
}
