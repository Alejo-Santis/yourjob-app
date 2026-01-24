<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    protected $table = 'applications';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'job_seeker_id',
        'job_listing_id',
        'cover_letter',
        'additional_answers',
        'status',
        'employer_response',
        'responded_at',
        'applied_at',
        'view_count',
        'last_viewed_at',
        'candidate_rating',
        'employer_rating',
        'rating_comment',
    ];

    protected $casts = [
        'additional_answers' => 'array',
        'applied_at' => 'datetime',
        'responded_at' => 'datetime',
        'last_viewed_at' => 'datetime',
        'candidate_rating' => 'integer',
        'employer_rating' => 'integer',
        'view_count' => 'integer',
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

    public function user()
    {
        return $this->jobSeeker->user();
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeViewed($query)
    {
        return $query->where('view_count', '>', 0);
    }

    public function scopeWithinDays($query, $days = 30)
    {
        return $query->where('applied_at', '>=', now()->subDays($days));
    }

    public function scopeRecentlyApplied($query, $days = 7)
    {
        return $query->where('applied_at', '>=', now()->subDays($days));
    }

    // Helper Methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function hasBeenViewed(): bool
    {
        return $this->view_count > 0;
    }

    public function getApplicationAge(): string
    {
        return $this->applied_at->diffForHumans();
    }

    public function getTimeSinceLastViewed(): ?string
    {
        return $this->last_viewed_at?->diffForHumans();
    }

    public function markAsViewed(): void
    {
        $this->increment('view_count');
        $this->update(['last_viewed_at' => now()]);
    }

    public function accept(string $message = ''): void
    {
        $this->update([
            'status' => 'accepted',
            'employer_response' => $message ?: $this->employer_response,
            'responded_at' => now(),
        ]);
    }

    public function reject(string $message = ''): void
    {
        $this->update([
            'status' => 'rejected',
            'employer_response' => $message ?: $this->employer_response,
            'responded_at' => now(),
        ]);
    }

    public function withdraw(): void
    {
        $this->update(['status' => 'withdrawn']);
    }
}
