<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [

        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        // gets all permissions via Gate::before rule; see AuthServiceProvider
        $role_admin =  Role::create(['name' => 'Admin']);
        $role_employee = Role::create(['name' => 'Patient']);
        $role_doctor = Role::create(['name' => 'Doctor']);


        $NormalPermissions = [

        ];
        $DRPermissions = [

        ];


        foreach ($NormalPermissions as $permission) {
            $role_employee->givePermissionTo($permission);
        }
        foreach ($DRPermissions as $permission) {
            $role_doctor->givePermissionTo($permission);
        }

        foreach ($permissions as $permission) {
            $role_admin->givePermissionto($permission);
        }


    }
}
