<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesticide_shops', function (Blueprint $table) {
            $table->string('surrounding_agreement_attachment')->nullable()->after('surrounding_agreements');
            $table->json('items')->nullable()->after('surrounding_agreement_attachment');
        });
    }

    public function down(): void
    {
        Schema::table('pesticide_shops', function (Blueprint $table) {
            $table->dropColumn(['surrounding_agreement_attachment', 'items']);
        });
    }
};
