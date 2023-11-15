<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('DELETE FROM roles');
        DB::table('roles')->insert([
            [
                'id'=>1,
                'name'=>'Vendor Administrator',
                'is_active'=>true,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]
        ]);
    }
}
