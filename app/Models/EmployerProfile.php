<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployerProfile extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'employer_profiles';

    protected $fillable = [
        'user_id',
        'company_name',
        'company_website',
        'company_description',
        'industry',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'employee_count',
        'company_size',
        'founding_year',
        'tax_id',
        'registration_number',
        'is_verified',
        'verification_notes',
        'logo_url',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'founding_year' => 'integer',
        'employee_count' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class, 'employer_id');
    }

    public function activeJobListings(): HasMany
    {
        return $this->jobListings()->where('status', 'active');
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeByIndustry($query, $industry)
    {
        return $query->where('industry', $industry);
    }

    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('is_active', true);
        });
    }

    // Helper Methods
    public function getActiveJobCount(): int
    {
        return $this->activeJobListings()->count();
    }

    public function getTotalApplications(): int
    {
        return JobListing::where('employer_id', $this->id)
            ->withCount('applications')
            ->get()
            ->sum('applications_count');
    }

    public function getAverageApplicationsPerJob(): float
    {
        $jobCount = $this->jobListings()->count();
        if ($jobCount === 0) {
            return 0;
        }

        return round($this->getTotalApplications() / $jobCount, 2);
    }

    public function isVerified(): bool
    {
        return $this->is_verified ?? false;
    }
}
