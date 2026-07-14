<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('personal_no', length: 20)->unique()->nullable(false);
            $table->string('name')->nullable(false);
            $table->enum('gender', ['male', 'female'])->nullable(false);
            $table->date('date_of_birth')->nullable(false);
            $table->string('first_joining_position')->nullable(false);
            $table->date('first_joining_date')->nullable(false);
            $table->string('current_position')->nullable(false);
            $table->date('current_position_joining_date')->nullable(false);
            $table->string('assigned_position')->nullable(false);
            $table->date('assigned_region_first_joining_date')->nullable(false);
            $table->string('current_region')->nullable(false);
            $table->string('current_office')->nullable(false);
            $table->string('current_branch')->nullable(false);
            $table->string('education_level')->nullable(false);
            $table->bigInteger('salary')->default(0);
            $table->boolean('is_married')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
