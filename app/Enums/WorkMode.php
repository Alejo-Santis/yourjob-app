<?php

namespace App\Enums;

enum WorkMode: string
{
    case ON_SITE = 'on_site';
    case REMOTE = 'remote';
    case HYBRID = 'hybrid';

    public function label(): string
    {
        return match ($this) {
            self::ON_SITE => 'On Site',
            self::REMOTE => 'Remote',
            self::HYBRID => 'Hybrid',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::ON_SITE => 'building',
            self::REMOTE => 'laptop',
            self::HYBRID => 'share-nodes',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::ON_SITE => 'bg-secondary',
            self::REMOTE => 'bg-success',
            self::HYBRID => 'bg-info',
        };
    }

    public static function choices(): array
    {
        return [
            self::ON_SITE->value => self::ON_SITE->label(),
            self::REMOTE->value => self::REMOTE->label(),
            self::HYBRID->value => self::HYBRID->label(),
        ];
    }
}
