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
        Schema::create('trainee_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('academic_year');
            $table->string('objective')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('status')->default(0);
            $table->foreignId('center_id')->nullable()->constrained('centers');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('fund_type_id')->nullable()->constrained('fund_types');
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
        Schema::dropIfExists('trainee_sessions');
    }
};
