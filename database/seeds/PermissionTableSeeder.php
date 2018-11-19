<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staff_role = \App\Role::where('slug', 'staff')->first();
        $admin_role = \App\Role::where('slug', 'admin')->first();

        $staff_permission = new \App\Permission();
        $staff_permission->slug = 'create-posts';
        $staff_permission->name = 'Create posts to describe products.';
        $staff_permission->save();
        $staff_permission->roles()->attach($staff_role);

        $admin_permission = new \App\Permission();
        $admin_permission->slug = 'edit-users';
        $admin_permission->name = 'Edit users in system.';
        $admin_permission->save();
        $admin_permission->roles()->attach($admin_role);
    }
}
