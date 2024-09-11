<?php

namespace Database\Seeders;

use App\Models\Post_permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postPerms = [
            'ทั้งหมด',
            'ฝ่าย',
            'ตำแหน่ง',
            'บุคคล',
        ];

        foreach ($postPerms as $postPerm) {
            Post_permission::create([
                'name' => $postPerm,
            ]);
        }
    }
}
