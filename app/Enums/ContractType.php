<?php

namespace App\Enums;

enum ContractType: string
{
    case FULL_TIME = 'full_time';
    case PART_TIME = 'part_time';
    case FREELANCE = 'freelance';
    case INTERNSHIP = 'internship';
    case TEMPORARY = 'temporary';
    case CONTRACT = 'contract';

    public function label(): string
    {
        return match ($this) {
            self::FULL_TIME => 'Full Time',
            self::PART_TIME => 'Part Time',
            self::FREELANCE => 'Freelance',
            self::INTERNSHIP => 'Internship',
            self::TEMPORARY => 'Temporary',
            self::CONTRACT => 'Contract',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::FULL_TIME => 'bg-primary',
            self::PART_TIME => 'bg-info',
            self::FREELANCE => 'bg-warning',
            self::INTERNSHIP => 'bg-secondary',
            self::TEMPORARY => 'bg-danger',
            self::CONTRACT => 'bg-success',
        };
    }

    public static function choices(): array
    {
        return [
            self::FULL_TIME->value => self::FULL_TIME->label(),
            self::PART_TIME->value => self::PART_TIME->label(),
            self::FREELANCE->value => self::FREELANCE->label(),
            self::INTERNSHIP->value => self::INTERNSHIP->label(),
            self::TEMPORARY->value => self::TEMPORARY->label(),
            self::CONTRACT->value => self::CONTRACT->label(),
        ];
    }
}
