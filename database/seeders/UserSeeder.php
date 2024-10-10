<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("DELETE FROM users WHERE id = 1");
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => "Md. Sehirul Islam Rehi",
                'email' => "mdsehirulislamrehi@gmail.com",
                'phone' => "01858361812",
                'image' => null,
                'password' => Hash::make("123456"),
                'role_id' => null,
                'is_active' => true,
                'is_super_admin' => true,
            ],
        ]);
    }
}
