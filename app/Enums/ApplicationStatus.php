<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case WITHDRAWN = 'withdrawn';
    case UNDER_REVIEW = 'under_review';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
            self::WITHDRAWN => 'Withdrawn',
            self::UNDER_REVIEW => 'Under Review',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING => 'bg-warning',
            self::ACCEPTED => 'bg-success',
            self::REJECTED => 'bg-danger',
            self::WITHDRAWN => 'bg-secondary',
            self::UNDER_REVIEW => 'bg-info',
        };
    }

    public function isResolved(): bool
    {
        return in_array($this, [self::ACCEPTED, self::REJECTED, self::WITHDRAWN]);
    }

    public static function choices(): array
    {
        return [
            self::PENDING->value => self::PENDING->label(),
            self::ACCEPTED->value => self::ACCEPTED->label(),
            self::REJECTED->value => self::REJECTED->label(),
            self::WITHDRAWN->value => self::WITHDRAWN->label(),
            self::UNDER_REVIEW->value => self::UNDER_REVIEW->label(),
        ];
    }
}
