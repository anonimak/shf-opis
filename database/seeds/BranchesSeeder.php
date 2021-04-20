<?php

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'branch_name' => 'Head Office',
                'is_head' => true
            ],
            [
                'branch_name' => 'Depok',
            ],
            [
                'branch_name' => 'Bogor',
            ],
        ];

        foreach ($branches as $value) {
            Branch::create($value);
        }
    }
}
