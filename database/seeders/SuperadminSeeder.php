<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => "superadmin",
            'name' => "SuperAdmin",
            'password' => "superadmin",
            'role' => "admin",
            'phone' => "081231921351",
            'deleted_at' => null,
        ]);
    }
}
