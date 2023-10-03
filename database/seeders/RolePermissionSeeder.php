<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperAdmin = Role::create(['name' => 'superadmin']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleEditor = Role::create(['name' => 'editor']);
        $rolePublisher = Role::create(['name' => 'publisher']);
        $roleUser = Role::create(['name' => 'user']);

        $permissions = [
            [
                'group_name' => 'dashboard',
                'permissions' => [
                    'dashboard.view',
                    'dashboard.edit',
                ]
            ],
              [
                'group_name' => 'listing',
                'permissions' => [
                    //Post Permission
                    'listing.view',
                    'listing.index',
                    'listing.create',
                    'listing.edit',
                    'listing.pending',
                    'listing.editor',
                    'listing.delete',
                ]
            ],
             [
                'group_name' => 'category',
                'permissions' => [
                    //Category Permission
                    'category.view',
                    'category.index',
                    'category.create',
                    'category.edit',
                    'category.delete',
                ]
            ],
            [
                'group_name' => 'settings',
                'permissions' => [
                    // Settings Permission
                    'settings.view',
                    'settings.general',
                    'settings.command',
                    'settings.backup.index',
                    'settings.backup.create',
                    'settings.backup.download',
                    'settings.backup.delete',

                ]
            ],

            [
                'group_name' => 'role',
                'permissions' => [
                    // Role Permission
                    'role.view',
                    'role.index',
                    'role.create',
                    'role.edit',
                    'role.delete',
                ]
            ],

            [
                'group_name' => 'user',
                'permissions' => [
                    // User Permission
                    'user.index',
                    'user.view',
                    'user.create',
                    'user.edit',
                    'user.delete',
                    'user.approve',
                ]
            ],

        ];

        for ($i = 0; $i < count($permissions); $i++) {
            $permissionGroup = $permissions[$i]['group_name'];
            for ($j = 0; $j < count($permissions[$i]['permissions']); $j++) {
                // Create Permission
                $permission = Permission::create(['name' => $permissions[$i]['permissions'][$j], 'group_name' => $permissionGroup]);
                $roleSuperAdmin->givePermissionTo($permission);
                $permission->assignRole($roleSuperAdmin);
            }
        }
    }


}
