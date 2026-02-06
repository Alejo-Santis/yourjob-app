<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasUuids;

    protected $table = 'favorites';

    protected $fillable = [
        'job_seeker_id',
        'job_listing_id',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
        return $query->where('is_active', true);
    }

    public function scopeByJobSeeker($query, $jobSeekerId)
    {
        return $query->where('job_seeker_id', $jobSeekerId);
    }

    // Helper Methods
    public function isActive(): bool
    {
        return $this->is_active ?? false;
    }

    public function toggleStatus(): void
    {
        $this->update(['is_active' => !$this->is_active]);
    }

    public function remove(): void
    {
        $this->delete();
    }
}
