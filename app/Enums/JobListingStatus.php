<?php

namespace App\Enums;

enum JobListingStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case CLOSED = 'closed';
    case FILLED = 'filled';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::CLOSED => 'Closed',
            self::FILLED => 'Filled',
            self::ARCHIVED => 'Archived',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-secondary',
            self::ACTIVE => 'bg-success',
            self::CLOSED => 'bg-danger',
            self::FILLED => 'bg-info',
            self::ARCHIVED => 'bg-dark',
        };
    }

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public static function choices(): array
    {
        return [
            self::DRAFT->value => self::DRAFT->label(),
            self::ACTIVE->value => self::ACTIVE->label(),
            self::CLOSED->value => self::CLOSED->label(),
            self::FILLED->value => self::FILLED->label(),
            self::ARCHIVED->value => self::ARCHIVED->label(),
        ];
    }
}
