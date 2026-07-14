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
        Schema::create('staff_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('staff_id'); 
            $table->enum('action', [
                'created',          
                'updated_profile',  
                'promoted_demoted', 
                'transferred',      
                'deleted'           
            ]);

            $table->json('changes')->nullable(); 
            $table->uuid('user_id')->nullable()->comment('The admin/staff member who made the change');

            $table->timestamps();
            $table->foreign('staff_id')
                  ->references('id')
                  ->on('staff')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_logs');
    }
};