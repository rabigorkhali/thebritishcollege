<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* CREATE  RANDOM USERS */
        // User::factory(10)->create();

        /* CREATE PRE-DEFINED USER */
        $userData = User::where('email', 'rabigorkhaly@gmail.com')->first();
        if (!$userData) {
            User::factory()->create([
                'name' => 'Rabi Gorkhali',
                'email' => 'rabigorkhaly@gmail.com',
                'password' => Hash::make('rabi@123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
