<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Super',
                'email' => 'super@admin.com',
                'id_employee' => 1,
                'email_verified_at' => now(),
                'role' => 2,
                'password' => Hash::make('kosong'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'id_employee' => 2,
                'email_verified_at' => now(),
                'role' => 1,
                'password' => Hash::make('kosong'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'id_employee' => 3,
                'email_verified_at' => now(),
                'role' => 0,
                'password' => Hash::make('kosong'),
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@user.com',
                'id_employee' => 4,
                'email_verified_at' => now(),
                'role' => 0,
                'password' => Hash::make('kosong'),
                'remember_token' => Str::random(10),
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
