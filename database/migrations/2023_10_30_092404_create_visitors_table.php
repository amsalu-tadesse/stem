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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_count');
            $table->string('actual_visitor')->nullable();
            $table->string('created_from')->nullable();
            $table->string('responsible_person');
            $table->string('phone');
            $table->string('email');
            $table->string('description')->nullable();
            $table->string('visiting_hr');
            $table->date('appointment_date');
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->foreignId('institution_type_id')->nullable()->constrained('institution_types');
            $table->foreignId('country_id')->nullable()->constrained('countries');
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
        Schema::dropIfExists('visitors');
    }
};
