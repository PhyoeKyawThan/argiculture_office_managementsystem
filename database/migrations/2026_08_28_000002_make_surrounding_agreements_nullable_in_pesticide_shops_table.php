<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesticide_shops', function (Blueprint $table) {
            $table->json('surrounding_agreements')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pesticide_shops', function (Blueprint $table) {
            $table->json('surrounding_agreements')->nullable(false)->change();
        });
    }
};
