<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fertilizer_distribution_licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->date('application_date')->nullable();
            $table->string('applicant_name');
            $table->string('shop_name')->nullable();
            $table->string('nrc_number');
            $table->string('education_level')->nullable();
            $table->boolean('work_experience')->default(false);
            $table->text('permanent_address')->nullable();
            $table->text('distribution_location_address')->nullable();
            $table->string('building_type')->nullable();
            $table->string('township')->nullable();
            $table->string('building_dimensions')->nullable();
            $table->json('attachment_nrc')->nullable(false); // nrc_front and nrc_end 
            $table->string('township_recommendation_letter')->nullable();
            $table->enum('status', ['pending', 'allowed', 'sending_to_regional_department', 'got_response_from_regional_department', 'completed', 'cancelled'])->default('pending');
            $table->string('cancelled_reason')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('fertilizer_license_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fertilizer_distribution_license_id')
                ->constrained('fertilizer_distribution_licenses', indexName: 'items_license_id_foreign')
                ->cascadeOnDelete();

            $table->string('fertilizer_name');
            $table->string('chemical_formula')->nullable();
            $table->string('fertilizer_type')->nullable();
            $table->string('packaging_size')->nullable();
            $table->string('weight_volume')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fertilizer_license_items');
        Schema::dropIfExists('fertilizer_distribution_licenses');
    }
};