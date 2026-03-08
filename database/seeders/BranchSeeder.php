<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['name' => 'Delhi Hub',     'code' => 'DEL', 'city' => 'New Delhi',  'state' => 'Delhi',         'pincode' => '110001'],
            ['name' => 'Mumbai Hub',    'code' => 'MUM', 'city' => 'Mumbai',     'state' => 'Maharashtra',   'pincode' => '400001'],
            ['name' => 'Chennai Hub',   'code' => 'CHN', 'city' => 'Chennai',    'state' => 'Tamil Nadu',    'pincode' => '600001'],
            ['name' => 'Kolkata Hub',   'code' => 'KOL', 'city' => 'Kolkata',    'state' => 'West Bengal',   'pincode' => '700001'],
            ['name' => 'Bangalore Hub', 'code' => 'BLR', 'city' => 'Bangalore',  'state' => 'Karnataka',     'pincode' => '560001'],
            ['name' => 'Hyderabad Hub', 'code' => 'HYD', 'city' => 'Hyderabad',  'state' => 'Telangana',     'pincode' => '500001'],
            ['name' => 'Pune Hub',      'code' => 'PUN', 'city' => 'Pune',       'state' => 'Maharashtra',   'pincode' => '411001'],
            ['name' => 'Ahmedabad Hub', 'code' => 'AMD', 'city' => 'Ahmedabad',  'state' => 'Gujarat',       'pincode' => '380001'],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch + ['is_active' => 1]);
        }
    }
}
