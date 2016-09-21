<?php

use Illuminate\Database\Seeder;
use App\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //delete
        User::truncate();

        //Insert
        User::insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'confirmed_at' => Carbon::now()
            ]
        ]);
        
        //Insert
        User::insert([
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => Hash::make('user'),
                'role' => 'user',
                'confirmed_at' => Carbon::now()
            ]
        ]);
    }
}
