<?php

use App\Models\Ref_Title;
use Illuminate\Database\Seeder;

class RefTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            [
                'title_name' => 'A.md'
            ],
            [
                'title_name' => 'SH',
            ],
            [
                'title_name' => 'SE',
            ],
        ];

        foreach ($titles as $value) {
            Ref_Title::create($value);
        }
    }
}
