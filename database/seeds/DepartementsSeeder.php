<?php

use App\Models\Departement;
use Illuminate\Database\Seeder;

class DepartementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departements = [
            [
                'departemenet_name' => 'Information and Technology'
            ],
            [
                'departemenet_name' => 'Risk Management',
            ],
            [
                'departemenet_name' => 'General Affairs',
            ],
            [
                'departemenet_name' => 'Tax',
            ],
            [
                'departemenet_name' => 'Litigation',
            ],
            [
                'departemenet_name' => 'Legan and Compliance',
            ],
            [
                'departemenet_name' => 'HRD',
            ],
            [
                'departemenet_name' => 'Finance and Accounting    ',
            ],
        ];

        foreach ($departements as $value) {
            Departement::create($value);
        }
    }
}
