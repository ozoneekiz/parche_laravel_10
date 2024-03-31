<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        [
            'name' => 'Administrator',
            'username' => 'admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'status' => '1', // '1' means 'active
            'created_at' => date("Y-m-d H:i:s")

        ]);

        DB::table('users')->insert(
        [
            'name' => 'User One',
            'username' => 'userone',
            'role' => 'user',
            'email' => 'user01@gmail.com',
            'password' => Hash::make('userone'),
            'status' => '1', // '0' means 'inactive
            'created_at' => date("Y-m-d H:i:s")

        ]);    
        
        DB::table('users')->insert(
        [
            'name' => 'User Two',
            'username' => 'usertwo',
            'role' => 'user',
            'email' => 'user02@gmail.com',
            'password' => Hash::make('usertwo'),
            'status' => '0', // '0' means 'inactive
            'created_at' => date("Y-m-d H:i:s")

        ]);

        
    }
}
