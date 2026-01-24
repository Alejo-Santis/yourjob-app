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
        Schema::create('employer_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();

            // Company Information
            $table->string('company_name')->nullable();
            $table->string('company_website')->nullable();
            $table->text('company_description')->nullable();
            $table->string('industry', 100)->nullable();

            // Contact Information
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('postal_code', 20)->nullable();

            // Company Details
            $table->integer('employee_count')->nullable();
            $table->string('company_size', 50)->nullable(); // 'startup', 'small', 'medium', 'large'
            $table->year('founding_year')->nullable();

            // Tax/Legal Information
            $table->string('tax_id')->nullable()->unique();
            $table->string('registration_number')->nullable()->unique();

            // Profile Status
            $table->boolean('is_verified')->default(false);
            $table->text('verification_notes')->nullable();
            $table->string('logo_url')->nullable();

            // Foreign Key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('company_name');
            $table->index('industry');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employer_profiles');
    }
};
