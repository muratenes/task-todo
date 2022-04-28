<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'DEV1',
            ],
            [
                'name' => 'DEV2',
            ],
            [
                'name' => 'DEV3',
            ],
            [
                'name' => 'DEV4',
            ],
            [
                'name' => 'DEV5',
            ],
        ];

        foreach ($users as $index => $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['name'] . "@gmail.com",
                'password' => Hash::make("1111111"),
                'power' => $index + 1
            ]);
        }
    }
}
