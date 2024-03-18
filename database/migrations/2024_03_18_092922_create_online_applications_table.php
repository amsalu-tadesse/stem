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
        Schema::create('online_applications', function (Blueprint $table) {
            $table->id();
            $table->string('applicant_name');
            $table->string("applicant_phone_number");
            $table->string("research_title");
            $table->string("statement_of_problem");
            $table->string("total_cost");
            $table->string("project_duration");
            $table->string("file_attachement");
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_applications');
    }
};
