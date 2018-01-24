<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Administrators';
        $user->email = 'ranudwis@gmail.com';
        $user->username = 'admin';
        $user->password = 'adminadmin';
        $user->gender = 'M';
        $user->level = '1';
        $user->save();
    }
}
