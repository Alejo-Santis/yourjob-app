<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobMatch extends Model
{
    use HasUuids;

    protected $table = 'job_matches';
    public $timestamps = false;

    protected $fillable = [
        'job_seeker_id',
        'job_listing_id',
        'match_score',
        'skills_match_score',
        'experience_match_score',
        'location_match_score',
        'salary_match_score',
        'missing_skills',
        'matching_skills',
        'match_notes',
        'status',
        'matched_at',
        'expired_at',
    ];

    protected $casts = [
        'match_score' => 'integer',
        'skills_match_score' => 'integer',
        'experience_match_score' => 'integer',
        'location_match_score' => 'integer',
        'salary_match_score' => 'integer',
        'missing_skills' => 'array',
        'matching_skills' => 'array',
        'matched_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    // Relationships
    public function jobSeeker(): BelongsTo
    {
        return $this->belongsTo(JobSeekerProfile::class, 'job_seeker_id');
    }

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_listing_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeHighScores($query, $minScore = 70)
    {
        return $query->where('match_score', '>=', $minScore);
    }

    public function scopeForJobSeeker($query, $jobSeekerId)
    {
        return $query->where('job_seeker_id', $jobSeekerId);
    }

    public function scopeForJobListing($query, $jobListingId)
    {
        return $query->where('job_listing_id', $jobListingId);
    }

    // Helper Methods
    public function getMatchQuality(): string
    {
        return match (true) {
            $this->match_score >= 90 => 'Excellent',
            $this->match_score >= 75 => 'Very Good',
            $this->match_score >= 60 => 'Good',
            $this->match_score >= 45 => 'Fair',
            default => 'Poor'
        };
    }

    public function isExcellentMatch(): bool
    {
        return $this->match_score >= 90;
    }

    public function isGoodMatch(): bool
    {
        return $this->match_score >= 70;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function hasExpired(): bool
    {
        return !is_null($this->expired_at) && $this->expired_at->isPast();
    }
}
