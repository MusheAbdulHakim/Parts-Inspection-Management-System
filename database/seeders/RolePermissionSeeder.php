<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $arrayOfPermissionNames = [
            'view-features', 'create-feature','edit-feature','destroy-feature',
            'view-controlPlans','create-controlPlan','edit-controlPlan','destroy-controlPlan',
            'view-projects','create-project','edit-project','destroy-project',
            'view-products','create-product','edit-product','destroy-product',
            'view-inspectionTools','create-inspectionTool','edit-inspectionTool','destroy-inspectionTool',
            'view-serialnumbers','create-serialnumber','edit-serialnumber','destroy-serialnumber',
            'view-backups','create-backup','download-backup','destroy-backup',
            'view-settings',
            'view-users','create-user','edit-user','show-user','destroy-user',
            'view-roles','create-role','edit-role','destroy-role',
            'view-permissions','create-permission','edit-permission','destroy-permission',
        ];
        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });
    
        Permission::insert($permissions->toArray());
        
        $admin = Role::create(['name' => 'super-admin']);
        $admin->givePermissionTo(Permission::all());
    }
}
