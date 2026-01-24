<?php

namespace App\Enums;

enum IdentificationType: string
{
    case CITIZENSHIP_CARD = 'citizenship_card';
    case NIT = 'nit';
    case WORK_PERMIT = 'work_permit';
    case PASSPORT = 'passport';
    case NATIONAL_ID = 'national_id';
    case DRIVER_LICENSE = 'driver_license';

    public function label(): string
    {
        return match ($this) {
            self::CITIZENSHIP_CARD => 'Citizenship Card',
            self::NIT => 'NIT',
            self::WORK_PERMIT => 'Work Permit',
            self::PASSPORT => 'Passport',
            self::NATIONAL_ID => 'National ID',
            self::DRIVER_LICENSE => 'Driver License',
        };
    }

    public static function choices(): array
    {
        return [
            self::CITIZENSHIP_CARD->value => self::CITIZENSHIP_CARD->label(),
            self::NIT->value => self::NIT->label(),
            self::WORK_PERMIT->value => self::WORK_PERMIT->label(),
            self::PASSPORT->value => self::PASSPORT->label(),
            self::NATIONAL_ID->value => self::NATIONAL_ID->label(),
            self::DRIVER_LICENSE->value => self::DRIVER_LICENSE->label(),
        ];
    }
}
