<?php

use App\Models\Ref_Position;
use Illuminate\Database\Seeder;

class RefPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                'position_name' => 'Staff IT',
                'id_department' => 1,
            ],
            [
                'position_name' => 'Head IT',
                'id_department' => 1,
            ],
            [
                'position_name' => 'Staff Risk Management',
                'id_department' => 2,
            ],
            [
                'position_name' => 'Head Risk Management',
                'id_department' => 2,
            ],
            [
                'position_name' => 'Staff General Affairs',
                'id_department' => 3,
            ],
            [
                'position_name' => 'Staff Tax',
                'id_department' => 4,
            ],
            [
                'position_name' => 'Head Tax',
                'id_department' => 4,
            ],
            [
                'position_name' => 'Staff Litigation',
                'id_department' => 5,
            ],
            [
                'position_name' => 'Head Litigation',
                'id_department' => 5,
            ],
            [
                'position_name' => 'Staff Legan and Compliance',
                'id_department' => 6,
            ],
            [
                'position_name' => 'Head Legan and Compliance',
                'id_department' => 6,
            ],
            [
                'position_name' => 'Head HRD',
                'id_department' => 7,
            ],
            [
                'position_name' => 'Staff HRD',
                'id_department' => 7,
            ],
            [
                'position_name' => 'Head Finance and Accounting',
                'id_department' => 8,
            ],
            [
                'position_name' => 'Staff Finance and Accounting',
                'id_department' => 8,
            ],
        ];

        foreach ($positions as $value) {
            Ref_Position::create($value);
        }
    }
}
