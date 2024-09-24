<?php

namespace Database\Seeders;

use App\Models\Position_permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post_perms = [
            [
                'name' => 'can_post',
                'label' => 'โพส/ประกาศ',
            ],
            [
                'name' => 'can_check',
                'label' => 'กรอกแบบฟอร์ม',
            ],
            [
                'name' => 'can_access_table',
                'label' => 'ทะเบียนเอกสาร',
            ],
            [
                'name' => 'can_approve_table',
                'label' => 'ตรวจสอบเอกสาร',
            ],
            [
                'name' => 'can_manage_form',
                'label' => 'จัดการแบบฟอร์ม',
            ],
            [
                'name' => 'can_manage_user',
                'label' => 'จัดการบัญชีผู้ใช้',
            ],
            [
                'name' => 'can_manage_org',
                'label' => 'จัดการข้อมูลองค์กร',
            ],
        ];
        foreach ($post_perms as $perm) {
            Position_permission::create([
                'perm_name' => $perm['name'],
                'label' => $perm['label']
            ]);
        }
    }
}
