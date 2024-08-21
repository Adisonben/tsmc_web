<?php

namespace Database\Seeders;

use App\Models\Prefix;
use App\Models\User;
use App\Models\User_detail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prefix = Prefix::where('name', 'นาย')->first();

        $adminUser = User::create([
            'user_id' => 'superadmin',
            'username' => 'tsmcadmin',
            'password' => Hash::make('iddrivesadmin'),
        ]);

        User_detail::create([
            'user_id' => $adminUser->id,
            'prefix' => $prefix?->id,
            'fname' => 'admin',
            'lname' => 'tsmc'
        ]);
    }
}
