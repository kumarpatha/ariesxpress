<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@ariesxpress.com',
            'password' => Hash::make('Admin@1234'),
            'role'     => 'super_admin',
            'mobile'   => '9999999999',
            'status'   => 1,
        ]);
    }
}
