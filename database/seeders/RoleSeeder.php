<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $moderatorRole = Role::create(['name' => 'moderator', 'guard_name' => 'web']);
        $developerRole = Role::create(['name' => 'developer', 'guard_name' => 'web']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);

        // Create basic permissions
        $manageUsersPermission = Permission::create(['name' => 'manage users', 'guard_name' => 'web']);
        $viewUsersPermission = Permission::create(['name' => 'view users', 'guard_name' => 'web']);
        
        $createProjectPermission = Permission::create(['name' => 'create project', 'guard_name' => 'web']);
        $editProjectPermission = Permission::create(['name' => 'edit project', 'guard_name' => 'web']);
        $deleteProjectPermission = Permission::create(['name' => 'delete project', 'guard_name' => 'web']);
        $approveProjectPermission = Permission::create(['name' => 'approve project', 'guard_name' => 'web']);
        
        $createDonationPermission = Permission::create(['name' => 'create donation', 'guard_name' => 'web']);
        $manageDonationsPermission = Permission::create(['name' => 'manage donations', 'guard_name' => 'web']);
        
        $manageVolunteersPermission = Permission::create(['name' => 'manage volunteers', 'guard_name' => 'web']);
        $becomeVolunteerPermission = Permission::create(['name' => 'become volunteer', 'guard_name' => 'web']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $moderatorRole->givePermissionTo([
            $viewUsersPermission,
            $approveProjectPermission,
            $manageDonationsPermission,
            $manageVolunteersPermission,
        ]);
        
        $developerRole->givePermissionTo([
            $createProjectPermission,
            $editProjectPermission,
        ]);
        
        $userRole->givePermissionTo([
            $createProjectPermission,
            $createDonationPermission,
            $becomeVolunteerPermission,
        ]);
    }
} 