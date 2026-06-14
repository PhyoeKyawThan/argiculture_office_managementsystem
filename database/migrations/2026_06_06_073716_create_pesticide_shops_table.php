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
            $table->string('shop_name');
            $table->string('owner_name');
            $table->string('license_number');
            $table->string('phone', 30);
            $table->string('email');
            $table->string('address');
            $table->string('township')->nullable();
            $table->string('region')->nullable();
            $table->string('status', 20)->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->unique('license_number');
            $table->unique('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesticide_shops');
    }
};
