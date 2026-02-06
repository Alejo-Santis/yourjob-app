<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSeekerProfile extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'job_seeker_profiles';

    protected $fillable = [
        'user_id',
        'full_name',
        'birth_date',
        'gender',
        'identification_number',
        'type_of_identification',
        'email',
        'phone',
        'alternate_phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'education_level',
        'academic_title',
        'educational_institution',
        'graduation_year',
        'profession',
        'total_years_experience',
        'skills',
        'languages',
        'expected_salary_min',
        'expected_salary_max',
        'preferred_contract_type',
        'preferred_work_mode',
        'preferred_locations',
        'inmediate_availability',
        'availability_date',
        'cv_url',
        'photo_url',
        'portfolio_url',
        'linkedin_url',
        'github_url',
        'about_me',
        'notes',
        'certifications',
        'profile_completion_percentage',
        'is_public',
        'accepts_recommendations',
    ];

    protected $casts = [
        'skills' => 'array',
        'languages' => 'array',
        'preferred_locations' => 'array',
        'certifications' => 'array',
        'birth_date' => 'date',
        'availability_date' => 'date',
        'expected_salary_min' => 'decimal:2',
        'expected_salary_max' => 'decimal:2',
        'inmediate_availability' => 'boolean',
        'is_public' => 'boolean',
        'accepts_recommendations' => 'boolean',
        'graduation_year' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class, 'job_seeker_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_seeker_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'job_seeker_id');
    }

    public function jobMatches(): HasMany
    {
        return $this->hasMany(JobMatch::class, 'job_seeker_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('is_active', true);
        });
    }

    public function scopeComplete($query)
    {
        return $query->where('profile_completion_percentage', '>=', 80);
    }

    // Helper Methods
    public function isProfileComplete(): bool
    {
        return $this->profile_completion_percentage >= 80;
    }

    public function calculateProfileCompletion(): int
    {
        $fields = [
            'full_name' => !empty($this->full_name),
            'birth_date' => !empty($this->birth_date),
            'phone' => !empty($this->phone),
            'address' => !empty($this->address),
            'education_level' => !empty($this->education_level),
            'profession' => !empty($this->profession),
            'skills' => !empty($this->skills) && count($this->skills) > 0,
            'cv_url' => !empty($this->cv_url),
        ];

        $completed = collect($fields)->filter(fn($v) => $v === true)->count();
        return (int)($completed / count($fields) * 100);
    }

    public function getFullNameAttribute(): string
    {
        return $this->attributes['full_name'] ?? 'Unnamed';
    }
}
