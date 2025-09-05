<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Umkn;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserUmknSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'owner@sepatu.com'],
            [
                'first_name' => 'Owner',
                'last_name'  => 'Test',
                'birth_date' => '1995-05-10',
                'role'       => 'user',
                'password'   => Hash::make('password123'),
            ]
        );

        $profile = Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'address'      => 'Jl. Siliwangi No. 4000, Cirebon',
                'number_phone' => '081234567890',
            ]
        );

        $umkn = Umkn::firstOrCreate(
            ['umkn_name' => 'Sepatu Mantap Jaya'],
            [
                'description'  => 'Toko sepatu berkualitas dengan harga terjangkau',
                'address'      => 'Jl. Siliwangi No. 4000, Cirebon',
                'number_phone' => '081234567890',
                'status'       => 'approved',
            ]
        );

        if (!$user->umkn_id) {
            $user->update(['umkn_id' => $umkn->id]);
        }
    }
}
