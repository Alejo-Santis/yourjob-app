<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkExperience extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'work_experiences';

    protected $fillable = [
        'job_seeker_id',
        'company_name',
        'job_title',
        'industry_sector',
        'start_date',
        'end_date',
        'currently_working',
        'description',
        'achievements',
        'skills_developed',
    ];

    protected $casts = [
        'skills_developed' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'currently_working' => 'boolean',
    ];

    // Relationships
    public function jobSeeker(): BelongsTo
    {
        return $this->belongsTo(JobSeekerProfile::class, 'job_seeker_id');
    }

    // Helper Methods
    public function getDurationInMonths(): int
    {
        $startDate = $this->start_date;
        $endDate = $this->currently_working ? now() : $this->end_date;

        return $startDate->diffInMonths($endDate);
    }

    public function getDurationInYears(): float
    {
        return round($this->getDurationInMonths() / 12, 1);
    }

    public function isCurrentlyWorking(): bool
    {
        return $this->currently_working ?? false;
    }
}
