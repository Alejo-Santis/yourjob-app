<?php

namespace App\Enums;

enum UserType: string
{
    case JOB_SEEKER = 'job_seeker';
    case EMPLOYER = 'employer';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::JOB_SEEKER => 'Job Seeker',
            self::EMPLOYER => 'Employer',
            self::ADMIN => 'Administrator',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::JOB_SEEKER => 'A person looking for employment opportunities',
            self::EMPLOYER => 'A company looking to hire talent',
            self::ADMIN => 'System administrator with full access',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::JOB_SEEKER => 'info',
            self::EMPLOYER => 'success',
            self::ADMIN => 'danger',
        };
    }

    public static function choices(): array
    {
        return [
            self::JOB_SEEKER->value => self::JOB_SEEKER->label(),
            self::EMPLOYER->value => self::EMPLOYER->label(),
            self::ADMIN->value => self::ADMIN->label(),
        ];
    }
}
