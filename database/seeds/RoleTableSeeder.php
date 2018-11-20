<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $staff_permission = App\Permission::where('slug', 'create-posts')->first();
        $admin_permission = App\Permission::where('slug', 'edit-users')->first();

        $staff_role = new \App\Role();
        $staff_role->slug = 'staff';
        $staff_role->name = 'Staff of Shopping Online';
        $staff_role->save();
        $staff_role->permissions()->attach($staff_permission);

        $admin_role = new \App\Role();
        $admin_role->slug = 'admin';
        $admin_role->name = 'Manager of Shopping Online';
        $admin_role->save();
        $admin_role->permissions()->attach($admin_permission);

        $user_role = new \App\Role();
        $user_role->slug = 'user';
        $user_role->name = 'Customer';
        $user_role->save();
    }
}
