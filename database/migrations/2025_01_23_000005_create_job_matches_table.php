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
        Schema::create('job_matches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_seeker_id');
            $table->uuid('job_listing_id');

            // Match Score (0-100)
            $table->integer('match_score')->default(0);

            // Match Details
            $table->integer('skills_match_score')->default(0);
            $table->integer('experience_match_score')->default(0);
            $table->integer('location_match_score')->default(0);
            $table->integer('salary_match_score')->default(0);

            // Reasons for match/mismatch
            $table->json('missing_skills')->nullable();
            $table->json('matching_skills')->nullable();
            $table->text('match_notes')->nullable();

            // Match Status
            $table->enum('status', ['active', 'archived', 'expired'])->default('active');
            $table->dateTime('matched_at');
            $table->dateTime('expired_at')->nullable();

            // Foreign Keys
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker_profiles')->onDelete('cascade');
            $table->foreign('job_listing_id')->references('id')->on('job_listings')->onDelete('cascade');

            // Indexes
            $table->index('job_seeker_id');
            $table->index('job_listing_id');
            $table->index('match_score');
            $table->index('status');
            $table->unique(['job_seeker_id', 'job_listing_id']); // One match per pair
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_matches');
    }
};
