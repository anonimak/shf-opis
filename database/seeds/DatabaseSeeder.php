<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CreateUsersSeeder::class,
            BranchesSeeder::class,
            DepartmentsSeeder::class,
            RefTitleSeeder::class,
            RefPositionSeeder::class,
            EmployeeSeeder::class
        ]);
    }
}
