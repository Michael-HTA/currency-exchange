<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $currencies = [
        ['USD','US Dollar','$'],
        ['THB','Thai Baht','฿'],
        ['PHP','Philippine Peso','₱'],
        ['SGD','Singapore Dollar','S$'],
        ['MYR','Malaysian Ringgit','RM'],
    ];
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);


        foreach($this->currencies as $currency){
            $currencyModel = new Currency();
            $currencyModel->code = $currency[0];
            $currencyModel->name = $currency[1];
            $currencyModel->symbol = $currency[2];
            $currencyModel->save();
        };
    }
}
