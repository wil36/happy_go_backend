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
            'name' => 'Castelnau-le-Lez',
            'code_shop' => ' tCuWKBy2MBWylhMYigTr',
            'email' => 'wesushu.castelnau@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Wscastelnau34'),
            'theme' => 0,
        ]);
        User::create([
            'name' => 'Pezenas',
            'code_shop' => 'WZEcwwSIbnngtpOugmTo',
            'email' => 'wesushu.pezenas@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Wspezenas34'),
            'theme' => 0,
        ]);
    }
}
