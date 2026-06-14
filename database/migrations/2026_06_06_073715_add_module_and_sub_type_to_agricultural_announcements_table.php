<?php

use App\Support\AgriculturalContentCatalog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agricultural_announcements', function (Blueprint $table) {
            $table->string('module', 40)->default(AgriculturalContentCatalog::MODULE_NEWS)->after('content');
            $table->string('sub_type', 40)->nullable()->after('module');
            $table->index(['module', 'sub_type']);
        });

        $rows = DB::table('agricultural_announcements')->orderBy('id')->get();

        foreach ($rows as $row) {
            $module = AgriculturalContentCatalog::LEGACY_CATEGORY_MAP[$row->category] ?? AgriculturalContentCatalog::MODULE_NEWS;

            DB::table('agricultural_announcements')
                ->where('id', $row->id)
                ->update(['module' => $module]);
        }

        Schema::table('agricultural_announcements', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('agricultural_announcements', function (Blueprint $table) {
            $table->string('category', 40)->default('news')->after('content');
            $table->index('category');
        });

        $rows = DB::table('agricultural_announcements')->orderBy('id')->get();

        foreach ($rows as $row) {
            $category = match ($row->module) {
                AgriculturalContentCatalog::MODULE_WEATHER => 'weather_alert',
                AgriculturalContentCatalog::MODULE_FARMING => 'farming_tip',
                default => 'news',
            };

            DB::table('agricultural_announcements')
                ->where('id', $row->id)
                ->update(['category' => $category]);
        }

        Schema::table('agricultural_announcements', function (Blueprint $table) {
            $table->dropIndex(['module', 'sub_type']);
            $table->dropColumn(['module', 'sub_type']);
        });
    }
};
