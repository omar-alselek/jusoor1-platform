<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create basic roles for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating roles...');

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator', 'guard_name' => 'web']);
        $developerRole = Role::firstOrCreate(['name' => 'developer', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        $this->info('Admin role ' . ($adminRole->wasRecentlyCreated ? 'created' : 'already exists'));
        $this->info('Moderator role ' . ($moderatorRole->wasRecentlyCreated ? 'created' : 'already exists'));
        $this->info('Developer role ' . ($developerRole->wasRecentlyCreated ? 'created' : 'already exists'));
        $this->info('User role ' . ($userRole->wasRecentlyCreated ? 'created' : 'already exists'));

        $this->info('All roles created successfully!');
        
        return Command::SUCCESS;
    }
} 