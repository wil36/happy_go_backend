<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin Happy Go',
            'email' => 'elandmail7@gmail.com',
            'phone' => '+237655091353',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
        ]);
    }
}
