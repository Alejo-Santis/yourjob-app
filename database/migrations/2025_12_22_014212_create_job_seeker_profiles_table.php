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
        Schema::create('job_seeker_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();

            // Personal Information
            $table->string('full_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            $table->string('identification_number')->nullable()->unique();
            $table->enum('type_of_identification', ['citizenship_card', 'nit', 'work_permit','passport', 'national_id', 'driver_license'])->nullable();

            // Contact Information
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('alternate_phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postal_code', 20)->nullable();

            //Education
            $table->string('education_level', 100)->nullable();
            $table->string('academic_title')->nullable();
            $table->string('educational_institution')->nullable();
            $table->integer('graduation_year')->nullable();

            // Professional
            $table->string('profession')->nullable();
            $table->integer('total_years_experience')->default(0);
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();

            //Job Preferences
            $table->decimal('expected_salary_min', 15, 2)->nullable();
            $table->decimal('expected_salary_max', 15, 2)->nullable();
            $table->enum('preferred_contract_type', ['full_time', 'part_time', 'freelance', 'internship', 'temporary'])->nullable();
            $table->enum('preferred_work_mode', ['on_site', 'remote', 'hybrid'])->nullable();
            $table->json('preferred_locations')->nullable();
            $table->boolean('inmediate_availability')->default(false);
            $table->date('availability_date')->nullable();

            // Documents
            $table->string('cv_url')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('github_url')->nullable();

            // Additional Information
            $table->text('about_me')->nullable();
            $table->text('notes')->nullable();
            $table->json('certifications')->nullable();

            // Profile Status
            $table->integer('profile_completion_percentage')->default(0);
            $table->boolean('is_public')->default(true);
            $table->boolean('accepts_recommendations')->default(true);

            // Foreign Key Constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('city');
            $table->index('profile_completion_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_seeker_profiles');
    }
};
