<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
        $staff_permission = App\Permission::where('slug', 'create-posts')->first();
        $admin_permission = App\Permission::where('slug', 'edit-users')->first();

        $staff = new \App\User();
        $staff->name = 'Duy';
        $staff->email = 'duy210697@gmail.com';
        $staff->password = bcrypt('12345678');
        $staff->email_verified_at = date("Y-m-d",time());
        $staff->save();
        $staff->roles()->attach($staff_role);
        $staff->permissions()->attach($staff_permission);

        $admin = new \App\User();
        $admin->name = 'Bin';
        $admin->email = 'bin210697@gmail.com';
        $admin->password = bcrypt('12345678');
        $admin->save();
        $admin->roles()->attach($admin_role);
        $admin->permissions()->attach($admin_permission);
    }
}
