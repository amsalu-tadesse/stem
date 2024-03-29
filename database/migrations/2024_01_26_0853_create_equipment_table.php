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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('count')->nullable();
            $table->string('current_quantity')->nullable();
            $table->foreignId('equipment_type_id')->nullable()->constrained('equipment_types');
            $table->foreignId('measurement_id')->nullable()->constrained('measurements');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('lab_id')->nullable()->constrained('labs');
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
        Schema::dropIfExists('equipment');
    }
};
