<?php

namespace App\Authorization;

class PermissionRegistry
{
    /**
     * Get the central permission definitions.
     */
    public static function all(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

            'users.view' => [
                'module' => 'System',
                'resource' => 'Users',
                'action' => 'View',
            ],

            'users.create' => [
                'module' => 'System',
                'resource' => 'Users',
                'action' => 'Create',
            ],

            'users.edit' => [
                'module' => 'System',
                'resource' => 'Users',
                'action' => 'Edit',
            ],

            'users.delete' => [
                'module' => 'System',
                'resource' => 'Users',
                'action' => 'Delete',
            ],

            /*
            |--------------------------------------------------------------------------
            | Roles
            |--------------------------------------------------------------------------
            */

            'roles.view' => [
                'module' => 'System',
                'resource' => 'Roles',
                'action' => 'View',
            ],

            'roles.create' => [
                'module' => 'System',
                'resource' => 'Roles',
                'action' => 'Create',
            ],

            'roles.edit' => [
                'module' => 'System',
                'resource' => 'Roles',
                'action' => 'Edit',
            ],

            'roles.delete' => [
                'module' => 'System',
                'resource' => 'Roles',
                'action' => 'Delete',
            ],

            /*
            |--------------------------------------------------------------------------
            | Permissions
            |--------------------------------------------------------------------------
            */

            'permissions.view' => [
                'module' => 'System',
                'resource' => 'Permissions',
                'action' => 'View',
            ],

            'permissions.create' => [
                'module' => 'System',
                'resource' => 'Permissions',
                'action' => 'Create',
            ],

            'permissions.edit' => [
                'module' => 'System',
                'resource' => 'Permissions',
                'action' => 'Edit',
            ],

            'permissions.delete' => [
                'module' => 'System',
                'resource' => 'Permissions',
                'action' => 'Delete',
            ],

            /*
            |--------------------------------------------------------------------------
            | Pages
            |--------------------------------------------------------------------------
            */

            'pages.view' => [
                'module' => 'Website',
                'resource' => 'Pages',
                'action' => 'View',
            ],

            'pages.create' => [
                'module' => 'Website',
                'resource' => 'Pages',
                'action' => 'Create',
            ],

            'pages.edit' => [
                'module' => 'Website',
                'resource' => 'Pages',
                'action' => 'Edit',
            ],

            'pages.delete' => [
                'module' => 'Website',
                'resource' => 'Pages',
                'action' => 'Delete',
            ],

            /*
            |--------------------------------------------------------------------------
            | Testimonials
            |--------------------------------------------------------------------------
            */

            'testimonials.view' => [
                'module' => 'Website',
                'resource' => 'Testimonials',
                'action' => 'View',
            ],

            'testimonials.create' => [
                'module' => 'Website',
                'resource' => 'Testimonials',
                'action' => 'Create',
            ],

            'testimonials.edit' => [
                'module' => 'Website',
                'resource' => 'Testimonials',
                'action' => 'Edit',
            ],

            'testimonials.delete' => [
                'module' => 'Website',
                'resource' => 'Testimonials',
                'action' => 'Delete',
            ],

        ];
    }

    /**
     * Get a single permission definition.
     */
    public static function get(string $permission): ?array
    {
        return self::all()[$permission] ?? null;
    }
}