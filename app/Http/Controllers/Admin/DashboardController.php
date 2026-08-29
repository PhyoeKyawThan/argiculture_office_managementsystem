<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgriculturalAnnouncement;
use App\Models\AgriculturalInquiry;
use App\Models\Category;
use App\Models\PesticideShop;
use App\Models\PesticideShopInspection;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = auth()->user()->isBackOffice() ? $this->dashboardStats() : [];

        return view('admin.dashboard.index', compact('stats'));
    }

    private function dashboardStats(): array
    {
        return [
            'monthLabels' => $this->monthLabels(),
            'monthlyInquiries' => $this->monthlyCounts(AgriculturalInquiry::class, 'created_at'),
            'monthlyAnnouncements' => $this->monthlyCounts(
                AgriculturalAnnouncement::class,
                'published_at',
                fn ($query) => $query->where('is_published', true)->whereNotNull('published_at')
            ),
            'monthlyInspections' => $this->monthlyCounts(PesticideShopInspection::class, 'inspection_date'),
            'inquiryStatus' => [
                'labels' => [
                    __('messages.inquiries.status_pending'),
                    __('messages.inquiries.status_answered'),
                ],
                'values' => [
                    AgriculturalInquiry::pending()->count(),
                    AgriculturalInquiry::answered()->count(),
                ],
            ],
            'announcementsByModule' => $this->announcementsByCategory(),
            'shopsByStatus' => $this->shopsByStatus(),
            'totals' => [
                'farmers' => User::query()->where('role', User::ROLE_FARMER)->count(),
                'inquiries' => AgriculturalInquiry::query()->count(),
                'announcements' => AgriculturalAnnouncement::query()->count(),
                'inspections' => PesticideShopInspection::query()->count(),
                'shops' => PesticideShop::query()->where('status', '=', PesticideShop::STATUS_APPROVED)->count(),
            ],
        ];
    }

    private function monthLabels(): array
    {
        return collect(range(5, 0))
            ->map(fn (int $i) => now()->subMonths($i)->translatedFormat('M Y'))
            ->values()
            ->all();
    }

    private function monthlyCounts(string $model, string $column, ?callable $scope = null): array
    {
        return collect(range(5, 0))
            ->map(function (int $i) use ($model, $column, $scope) {
                $month = now()->subMonths($i);
                $query = $model::query()
                    ->whereBetween($column, [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()]);

                if ($scope) {
                    $scope($query);
                }

                return $query->count();
            })
            ->values()
            ->all();
    }

    private function announcementsByCategory(): array
    {
        $rootCategories = Category::where('level', 1)->get();
        $labels = [];
        $values = [];

        foreach ($rootCategories as $index => $category) {
            $labels[$index] = config('app.locale') == 'my' ? $category->name_mm ?? $category->name : $category->name;
            $values[$index] = AgriculturalAnnouncement::where('category_id', $category->id)->count();
            $category->relationLoaded('children');
            foreach ($category->children as $child_category){
                $values[$index] += AgriculturalAnnouncement::where('category_id', $child_category->id)->count();
                $child_category->relationLoaded('children');
                foreach($child_category->children as $grand_child_category){
                    $values[$index] += AgriculturalAnnouncement::where('category_id', $grand_child_category->id)->count();
                }
            }
        }

        return ['labels' => $labels, 'values' => $values];
    }

    private function shopsByStatus(): array
    {
        $counts = PesticideShop::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'labels' => [
                __('messages.shop_reg.statuses.pending'),
                __('messages.shop_reg.statuses.approved'),
                __('messages.shop_reg.statuses.rejected'),
            ],
            'values' => [
                (int) ($counts[PesticideShop::STATUS_PENDING] ?? 0),
                (int) ($counts[PesticideShop::STATUS_APPROVED] ?? 0),
                (int) ($counts[PesticideShop::STATUS_REJECTED] ?? 0),
            ],
        ];
    }
}