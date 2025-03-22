<?php

namespace Database\Seeders;

use App\User;
use App\SmStaff;
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
        DB::transaction(function () {
            SmStaff::where('role_id', 5)->update(['role_id' => 1]);
            $staffMembers = SmStaff::where('role_id', 1)->pluck('user_id');
            User::whereIn('id', $staffMembers)->update(['role_id' => 1, 'is_administrator' => 'yes']);
        });
    }
}
