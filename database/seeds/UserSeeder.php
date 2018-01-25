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

        $user = new User();
        $user->name = 'Satu';
        $user->email = 'satu@satu.satu';
        $user->username = 'satu';
        $user->password = 'satu';
        $user->gender = 'M';
        $user->level = '0';
        $user->save();

        $user = new User();
        $user->name = 'Dua';
        $user->email = 'dua@dua.dua';
        $user->username = 'dua';
        $user->password = 'dua';
        $user->gender = 'M';
        $user->address = 'Jalan Bhayangkara';
        $user->level = '0';
        $user->save();
    }
}
