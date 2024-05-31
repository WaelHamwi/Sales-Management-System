<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample currency data
        $currencies = [
            ['name' => 'US Dollar', 'symbol' => '$'],
            ['name' => 'Euro', 'symbol' => '€'],
            ['name' => 'British Pound', 'symbol' => '£'],
            ['name' => 'Japanese Yen', 'symbol' => '¥'],
            ['name' => 'Australian Dollar', 'symbol' => 'A$'],
            ['name' => 'Syrian Pound', 'symbol' => 'SYP'],
            ['name' => 'Saudi Riyal', 'symbol' => 'ر.س'],
            ['name' => 'Qatari Riyal', 'symbol' => 'ر.ق'],
            ['name' => 'Egyptian Pound', 'symbol' => 'E£'],
            ['name' => 'Kuwaiti Dinar', 'symbol' => 'د.ك'],
        ];
        

        // Inserting data into the currencies table
        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
