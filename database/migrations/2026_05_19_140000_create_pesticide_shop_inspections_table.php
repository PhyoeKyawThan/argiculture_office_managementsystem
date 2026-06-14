<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesticide_shop_inspections', function (Blueprint $table) {
            $table->id();
            $table->uuid('inspector_staff_id');
            $table->string('owner_name');
            $table->text('shop_address');
            $table->string('township')->default('Hinthada');
            $table->date('inspection_date');
            $table->boolean('is_registered_pesticide')->default(false);
            $table->boolean('has_valid_retail_license')->default(false);
            $table->date('license_expiry_date')->nullable();
            $table->boolean('complies_with_pesticide_law')->default(false);
            $table->boolean('has_training_certificate')->default(false);
            $table->text('raw_findings_notes')->nullable();
            $table->string('action_taken')->nullable();
            $table->json('photos')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('inspector_staff_id')
                ->references('id')
                ->on('staff')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesticide_shop_inspections');
    }
};
