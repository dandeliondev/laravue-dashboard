<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'color', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Permission catalogue, grouped for the permissions matrix UI.
     *
     * @return array<string, array<string, string>>
     */
    public static function permissionGroups(): array
    {
        return [
            'Users' => [
                'users.view' => 'View users',
                'users.create' => 'Create users',
                'users.edit' => 'Edit users',
                'users.delete' => 'Delete users',
            ],
            'Roles' => [
                'roles.view' => 'View roles',
                'roles.manage' => 'Manage roles & permissions',
            ],
            'Content' => [
                'content.view' => 'View content',
                'content.publish' => 'Publish content',
            ],
            'Settings' => [
                'settings.view' => 'View settings',
                'settings.manage' => 'Manage settings',
            ],
        ];
    }

    /**
     * Flat list of every permission key.
     *
     * @return array<int, string>
     */
    public static function allPermissionKeys(): array
    {
        return collect(static::permissionGroups())
            ->flatMap(fn ($perms) => array_keys($perms))
            ->all();
    }
}
