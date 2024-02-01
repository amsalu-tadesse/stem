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
        Schema::create('trainee_session_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainee_session_id')->nullable()->constrained('trainee_sessions');
            $table->string('quantity')->nullable();
            $table->foreignId('equipment_id')->nullable()->constrained('equipment');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainee_session_equipment');
    }
};
