<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesticide_shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('township');
            $table->string('nrc')->unique();
            $table->string('education');
            $table->string('stable_address');
            $table->string('requested_selling_address');
            $table->string('building_type');
            $table->string('building_area');
            $table->boolean('has_emergency_preparedness_plan')->default(false);
            $table->string('from_restaurant_distance');
            $table->enum('retail_or_wholesale', ['retail', 'wholesale']);
            $table->string('signature');
            $table->json('attachments'); // certified_pesticide_application_card(back and front), certified_pesticide_application_cerfificate, Ward_administrator_approval.
            $table->json('surrounding_agreements');// Village, Village Tract, Township, Region/State, name, nrc, store_front(signature, name, nrc), store_end(signature, name, nrc), store_south(signature, name, nrc), store_north(signature, name, nrc), signature(signature, name, nrc),
            $table->string('status', 20)->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesticide_shops');
    }
};
