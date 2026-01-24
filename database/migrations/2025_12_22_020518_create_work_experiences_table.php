2<?php

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
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_seeker_id');

            // Job information
            $table->string('company');
            $table->string('position');
            $table->string('industry_sector', 100)->nullable();

            // Dates
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->boolean('currently_working')->default(false);

            // Description
            $table->text('description')->nullable();
            $table->text('achievements')->nullable();
            $table->json('skills_developed')->nullable();

            // Foreign key constraint
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker_profiles')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('job_seeker_id');
            $table->index('currently_working');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_experiences');
    }
};
