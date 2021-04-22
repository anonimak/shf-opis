<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'department_name' => 'Information and Technology'
            ],
            [
                'department_name' => 'Risk Management',
            ],
            [
                'department_name' => 'General Affairs',
            ],
            [
                'department_name' => 'Tax',
            ],
            [
                'department_name' => 'Litigation',
            ],
            [
                'department_name' => 'Legan and Compliance',
            ],
            [
                'department_name' => 'HRD',
            ],
            [
                'department_name' => 'Finance and Accounting    ',
            ],
        ];

        foreach ($departments as $value) {
            Department::create($value);
        }
    }
}
