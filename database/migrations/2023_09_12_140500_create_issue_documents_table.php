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
        Schema::create('issue_documents', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->foreignId('file_category_id')->nullable()->constrained('file_categories');
            $table->foreignId('issue_id')->nullable()->constrained('issues');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_documents');
    }
};
