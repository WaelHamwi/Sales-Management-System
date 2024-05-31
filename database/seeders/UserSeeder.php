<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create an user user


      /*  user::create([
            'first_name' => 'test2',
            'last_name' => 'user',
            'email' => 'test@test.com',
            'password' => bcrypt('test'),
        ]);*/
       /* user::create([
             'first_name' => 't',
             'last_name' => 'user',
             'email' => 't@t.com',
             'password' => bcrypt('t'),
         ]);*/
         user::create([
            'first_name' => 't',
            'last_name' => 'user',
            'email' => 't@t.t',
            'password' => bcrypt('t'),
        ]);

        // Add more seed data as needed
    }
}
