<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rangga Manggala Yudha',
            'birth' => '24-05-2000',
            'gender' => 'male',
            'address' => 'Rt.022/Rw.009, Dusun V Wage, Desa/Kec. Maleber, Kuningan 45575',
            'avatar' => 'ryudhaa.png',
            'username' => 'admin',
            'email' => 'mryudha424@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'Administrator'
        ]);

        User::factory(4)->create();
    }
}
