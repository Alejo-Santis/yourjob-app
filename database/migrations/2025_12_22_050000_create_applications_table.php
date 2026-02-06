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
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_seeker_id');
            $table->uuid('job_listing_id');

            // Application Content
            $table->text('cover_letter')->nullable();
            $table->json('additional_answers')->nullable();

            // Application Status
            $table->enum('status', ['pending', 'accepted', 'rejected', 'withdrawn', 'under_review'])->default('pending');
            $table->text('rejection_message')->nullable();

            // Application History
            $table->dateTime('applied_at');
            $table->dateTime('viewed_at')->nullable();
            $table->dateTime('accepted_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('withdrawn_at')->nullable();
            $table->integer('view_count')->default(0);

            // Rating
            $table->integer('candidate_rating')->nullable(); // 1-5 stars
            $table->integer('employer_rating')->nullable(); // 1-5 stars
            $table->text('rating_comment')->nullable();

            // Foreign Keys
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker_profiles')->onDelete('cascade');
            $table->foreign('job_listing_id')->references('id')->on('job_listings')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('job_seeker_id');
            $table->index('job_listing_id');
            $table->index('status');
            $table->index('applied_at');
            $table->unique(['job_seeker_id', 'job_listing_id']); // Prevent duplicate applications
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
