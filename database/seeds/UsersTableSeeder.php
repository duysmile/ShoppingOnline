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
        DB::table('users')->insert([
           'name' => 'admin',
           'email' => 'duy210697@gmail.com',
           'password' => bcrypt('12345678'),
            'email_verified_at' => date("Y-m-d",time())
        ]);
    }
}
