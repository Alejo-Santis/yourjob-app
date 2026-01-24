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
        Schema::create('favorites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('job_seeker_id');
            $table->uuid('job_listing_id');

            // Notes about why this is a favorite
            $table->text('notes')->nullable();

            // Status
            $table->boolean('is_active')->default(true);

            // Foreign Keys
            $table->foreign('job_seeker_id')->references('id')->on('job_seeker_profiles')->onDelete('cascade');
            $table->foreign('job_listing_id')->references('id')->on('job_listings')->onDelete('cascade');

            $table->timestamps();

            // Indexes
            $table->index('job_seeker_id');
            $table->index('job_listing_id');
            $table->unique(['job_seeker_id', 'job_listing_id']); // Prevent duplicate favorites
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
