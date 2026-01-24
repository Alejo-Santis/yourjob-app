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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employer_id');

            // Job Information
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();

            // Job Details
            $table->string('position_level', 50)->nullable(); // 'entry', 'mid', 'senior', 'lead'
            $table->integer('years_experience_required')->default(0);
            $table->string('industry_sector', 100)->nullable();

            // Compensation
            $table->decimal('salary_min', 15, 2)->nullable();
            $table->decimal('salary_max', 15, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('salary_period', 20)->nullable(); // 'monthly', 'yearly'

            // Work Conditions
            $table->enum('contract_type', ['full_time', 'part_time', 'freelance', 'internship', 'temporary', 'contract'])->default('full_time');
            $table->enum('work_mode', ['on_site', 'remote', 'hybrid'])->default('on_site');

            // Location
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();

            // Skills and Tags
            $table->json('required_skills')->nullable();
            $table->json('nice_to_have_skills')->nullable();
            $table->json('tags')->nullable();

            // Status
            $table->enum('status', ['draft', 'active', 'closed', 'filled', 'archived'])->default('draft');
            $table->integer('vacancy_count')->default(1);
            $table->integer('applications_count')->default(0);

            // Dates
            $table->dateTime('posted_at')->nullable();
            $table->dateTime('deadline_at')->nullable();
            $table->dateTime('closed_at')->nullable();

            // Foreign Key
            $table->foreign('employer_id')->references('id')->on('employer_profiles')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('employer_id');
            $table->index('status');
            $table->index('posted_at');
            $table->index('contract_type');
            $table->fullText(['title', 'description']); // For full-text search
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
