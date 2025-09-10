<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@example.test'],
            [
                'first_name' => 'Admin',
                'birth_date' => '1995-05-10',
                'role'       => 'admin',
                'password'   => Hash::make('password'),
            ]
        );

        $profile = Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'address'      => 'Jl. Arum Sari No. 4000, Cirebon',
                'number_phone' => '081234567890',
            ]
        );
    }
}
