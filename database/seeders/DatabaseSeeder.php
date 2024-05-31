<?php

use Illuminate\Database\Seeder;
use Database\Seeders\userSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            userSeeder::class,
        ]);
    }
}
