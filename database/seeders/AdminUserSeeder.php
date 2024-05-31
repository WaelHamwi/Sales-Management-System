<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('wael'),
            'type' => 'admin',
            'image'=>'image1',
        ]);
        User::create([
            'first_name' => 'wael',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
            'type' => 'user',
            'image'=>'image2',
        ]);
        User::create([
            'first_name' => 'wael1',
            'last_name' => 'User',
            'email' => 'test1@test1.com',
            'password' => bcrypt('password'),
            'type' => 'user',
              'image'=>'image3',
        ]);


        // Add more seed data as needed
    }
}
