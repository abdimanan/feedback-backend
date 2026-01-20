<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case PROJECT_MANAGER = 'project_manager';

    /**
     * Get the label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::PROJECT_MANAGER => 'Project Manager',
        };
    }

    /**
     * Get all role values.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all role cases.
     *
     * @return array<Role>
     */
    public static function all(): array
    {
        return self::cases();
    }
}
