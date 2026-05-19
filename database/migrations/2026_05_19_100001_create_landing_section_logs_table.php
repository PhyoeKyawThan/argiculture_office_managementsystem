<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_section_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_section_id')->nullable()->constrained('landing_sections')->nullOnDelete();
            $table->enum('action', ['created', 'updated', 'deleted']);
            $table->json('changes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_section_logs');
    }
};
