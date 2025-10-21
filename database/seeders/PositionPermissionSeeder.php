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
                'label' => 'เอกสาร',
            ],
            [
                'name' => 'can_access_table',
                'label' => 'ทะเบียนเอกสาร',
            ],
            [
                'name' => 'can_manage_form',
                'label' => 'จัดการแบบฟอร์ม',
            ],
            [
                'name' => 'can_assign_driver',
                'label' => 'จัดการผู้ประจำรถ',
            ],
            [
                'name' => 'can_export',
                'label' => 'ออกรายงาน',
            ],
            [
                'name' => 'can_manage_user',
                'label' => 'จัดการบัญชีผู้ใช้',
            ],
            [
                'name' => 'can_manage_org',
                'label' => 'จัดการข้อมูลบริษัท',
            ],
            [
                'name' => 'can_see_all_docs',
                'label' => 'มองเห็นเอกสารทั้งหมด',
            ],
            [
                'name' => 'can_record_work',
                'label' => 'บันทึกเวลาทำงาน',
            ],
            [
                'name' => 'work_record_table',
                'label' => 'ทะเบียนบันทึกเวลาทำงาน',
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
