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
        Schema::create('pesticide_shops_license', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesticide_shop_id')
                ->nullable()
                ->constrained('pesticide_shops')
                ->nullOnDelete();
            $table->string('license_number')->unique();
            $table->string('name');
            $table->string('nrc')->unique();
            $table->string('shop_address');
            $table->date('issued_date');
            $table->date('expiry_date');
            $table->foreignId('issued_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesticide_shops_license');
    }
};
