<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobListing extends Model
{
    use SoftDeletes;

    protected $table = 'job_listings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'requirements',
        'benefits',
        'position_level',
        'years_experience_required',
        'industry_sector',
        'salary_min',
        'salary_max',
        'currency',
        'salary_period',
        'contract_type',
        'work_mode',
        'city',
        'state',
        'country',
        'required_skills',
        'nice_to_have_skills',
        'tags',
        'status',
        'vacancy_count',
        'applications_count',
        'posted_at',
        'deadline_at',
        'closed_at',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'nice_to_have_skills' => 'array',
        'tags' => 'array',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'posted_at' => 'datetime',
        'deadline_at' => 'datetime',
        'closed_at' => 'datetime',
        'years_experience_required' => 'integer',
        'vacancy_count' => 'integer',
        'applications_count' => 'integer',
    ];

    // Relationships
    public function employer(): BelongsTo
    {
        return $this->belongsTo(EmployerProfile::class, 'employer_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class, 'job_listing_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'job_listing_id');
    }

    public function jobMatches(): HasMany
    {
        return $this->hasMany(JobMatch::class, 'job_listing_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('deadline_at')
                    ->orWhere('deadline_at', '>=', now());
            });
    }

    public function scopeByWorkMode($query, $workMode)
    {
        return $query->where('work_mode', $workMode);
    }

    public function scopeByContractType($query, $contractType)
    {
        return $query->where('contract_type', $contractType);
    }

    public function scopeByLocation($query, $city, $state = null)
    {
        return $query->where('city', $city)
            ->when($state, fn($q) => $q->where('state', $state));
    }

    public function scopeSearchByTitle($query, $title)
    {
        return $query->whereFullText(['title', 'description'], $title);
    }

    public function scopeByIndustry($query, $industry)
    {
        return $query->where('industry_sector', $industry);
    }

    public function scopeRecentlyPosted($query, $days = 7)
    {
        return $query->where('posted_at', '>=', now()->subDays($days));
    }

    // Helper Methods
    public function isActive(): bool
    {
        return $this->status === 'active'
            && (is_null($this->deadline_at) || $this->deadline_at->isFuture());
    }

    public function isClosed(): bool
    {
        return in_array($this->status, ['closed', 'filled', 'archived']);
    }

    public function getApplicationCount(): int
    {
        return $this->applications()->count();
    }

    public function getPendingApplicationsCount(): int
    {
        return $this->applications()->where('status', 'pending')->count();
    }

    public function getFavoriteCount(): int
    {
        return $this->favorites()->count();
    }

    public function getFormattedSalaryRange(): string
    {
        if (is_null($this->salary_min) && is_null($this->salary_max)) {
            return 'Not specified';
        }

        $min = $this->salary_min ? number_format($this->salary_min, 0) : '0';
        $max = $this->salary_max ? number_format($this->salary_max, 0) : '∞';

        return "{$this->currency} {$min} - {$max} {$this->salary_period}";
    }

    public function getDaysUntilDeadline(): ?int
    {
        if (is_null($this->deadline_at)) {
            return null;
        }

        return now()->diffInDays($this->deadline_at, false);
    }

    public function hasDeadlineExpired(): bool
    {
        return !is_null($this->deadline_at) && $this->deadline_at->isPast();
    }
}
