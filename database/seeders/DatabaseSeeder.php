<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $codeToId = [
        'MYR' => 5,
        'THB' => 2,
        'SGD' => 4,
        'PHP' => 3,
    ];

    private $exchangeRates = [
        "2025-01-28" => [
            "MYR" => 4.390470774,
            "PHP" => 58.3452614733,
            "SGD" => 1.3485201537,
            "THB" => 33.8624263476,
        ],
        "2025-01-27" => [
            "MYR" => 4.390470774,
            "PHP" => 58.3452614733,
            "SGD" => 1.3485201537,
            "THB" => 33.8624263476,
        ],
        "2025-01-26" => [
            "MYR" => 4.3848406556,
            "PHP" => 58.2850596472,
            "SGD" => 1.3473901531,
            "THB" => 33.6574958031,
        ],
        "2025-01-25" => [
            "MYR" => 4.3752906392,
            "PHP" => 58.284308313,
            "SGD" => 1.3444901538,
            "THB" => 33.5401049111,
        ],
        "2025-01-24" => [
            "MYR" => 4.3752908344,
            "PHP" => 58.2843094735,
            "SGD" => 1.3444901361,
            "THB" => 33.5401043188,
        ],
        "2025-01-23" => [
            "MYR" => 4.4438608587,
            "PHP" => 58.639269644,
            "SGD" => 1.3555201464,
            "THB" => 33.9808063958,
        ],
        "2025-01-22" => [
            "MYR" => 4.4358707066,
            "PHP" => 58.5323258862,
            "SGD" => 1.354190142,
            "THB" => 33.8744341493,
        ],
        "2025-01-21" => [
            "MYR" => 4.4813005612,
            "PHP" => 58.3569180125,
            "SGD" => 1.354440222,
            "THB" => 33.9878450455,
        ],
        "2025-01-20" => [
            "MYR" => 4.4917707674,
            "PHP" => 58.1967602648,
            "SGD" => 1.3534702584,
            "THB" => 34.1161334428,
        ],
    ];


    private $currencies = [
        ['USD', 'US Dollar', '$'],
        ['THB', 'Thai Baht', '฿'],
        ['PHP', 'Philippine Peso', '₱'],
        ['SGD', 'Singapore Dollar', 'S$'],
        ['MYR', 'Malaysian Ringgit', 'RM'],
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


        foreach ($this->currencies as $currency) {
            $currencyModel = new Currency();
            $currencyModel->code = $currency[0];
            $currencyModel->name = $currency[1];
            $currencyModel->symbol = $currency[2];
            $currencyModel->save();
        };


        foreach ($this->exchangeRates as $key => $values) {
            foreach ($values as $secondKey => $value) {
                $model = new ExchangeRate();
                $model->base_id = 1;
                $model->target_id = $this->codeToId[$secondKey];
                $model->created_at = $key;
                $model->rate = $value;
                $model->save();
            }
        }
    }
}
