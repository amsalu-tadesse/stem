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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('private_benefit')->nullable();
            $table->text('public_benefit')->nullable();

            $table->longText('approved_message')->nullable();
            $table->longText('requested_message')->nullable();
            $table->longText('rejected_message')->nullable();
            $table->foreignId('responsible_institution')->nullable()->constrained('organizations');
            $table->foreignId('responsible_person')->nullable()->constrained('users');
            $table->foreignId('kpi')->nullable()->constrained('kpis');
            $table->foreignId('issue_level')->nullable()->constrained('organization_levels');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('region_id')->nullable()->constrained('regions');
            $table->foreignId('zone_id')->nullable()->constrained('zones');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
