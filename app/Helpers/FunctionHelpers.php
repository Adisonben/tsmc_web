<?php

namespace App\Helpers;

use App\Models\Department; // สมมติว่า Model ของฝ่ายชื่อ Department
use App\Models\Branch; // สมมติว่า Model ของสาขาชื่อ Branch

class FunctionHelpers
{
    public static function getDepartments()
    {
        return Department::all();
    }

    public static function getBranches()
    {
        return Branch::all();
    }

    public static function getPageTitle($routeName = null)
    {
        $routeName = $routeName ?? request()->route()->getName();
        
        $pageTitles = [
            'home' => 'หน้าหลัก',
            'manage.data' => 'จัดการข้อมูล',
            'posts.index' => 'โพส/ประกาศ',
            'posts.create' => 'สร้างโพสใหม่',
            'posts.show' => 'รายละเอียดโพส',
            'posts.edit' => 'แก้ไขโพส',
            'document.fill-out.selectform' => 'เลือกแบบฟอร์ม',
            'document.fill-out' => 'ทำเอกสาร 5 หมวด',
            'document.table.selectform' => 'เลือกทะเบียนเอกสาร',
            'document.table' => 'ทะเบียนเอกสาร',
            'document.submission.show' => 'รายละเอียดเอกสาร',
            'document.submission.edit' => 'แก้ไขเอกสาร',
            'document.export.filter' => 'ค้นหาและออกรายงาน',
            'work-records.table' => 'ทะเบียนเวลาทำงาน',
            'work-records.geomap' => 'แผนที่ตำแหน่ง',
            'car.ma.table' => 'บันทึกการบำรุงรักษารถ',
            'car.ma.form' => 'บันทึกการบำรุงรักษา',
            'car.ma.detail' => 'รายละเอียดการบำรุงรักษา',
            'logbook.table' => 'Log Book',
            'logbook.create' => 'สร้าง Log Book',
            'logbook.show' => 'รายละเอียด Log Book',
            'elearning' => 'ความรู้ออนไลน์',
            'performance.report' => 'รายงานผลส่งกรมฯ',
            'submission.count' => 'จำนวนการทำเอกสาร 5 หมวด',
            'users.index' => 'บัญชีผู้ใช้ทั้งหมด',
            'users.show' => 'รายละเอียดผู้ใช้',
            'users.create' => 'เพิ่มผู้ใช้ใหม่',
            'users.edit' => 'แก้ไขข้อมูลผู้ใช้',
            'users.editByOwn' => 'แก้ไขโปรไฟล์',
            'organizations.index' => 'ข้อมูลบริษัท',
            'organizations.show' => 'รายละเอียดบริษัท',
            'organizations.create' => 'เพิ่มบริษัทใหม่',
            'organizations.edit' => 'แก้ไขข้อมูลบริษัท',
            'positions.index' => 'ตำแหน่ง',
            'positions.create' => 'เพิ่มตำแหน่งใหม่',
            'positions.edit' => 'แก้ไขตำแหน่ง',
            'posit.perm' => 'สิทธิ์การเข้าถึง',
            'vehicles.index' => 'ข้อมูลรถ',
            'vehicles.show' => 'รายละเอียดรถ',
            'vehicles.create' => 'เพิ่มรถใหม่',
            'vehicles.edit' => 'แก้ไขข้อมูลรถ',
            'vehicle.assignment.table' => 'จัดการผู้ประจำรถ',
            'form.select-form-category' => 'จัดการแบบฟอร์ม',
            'form.table' => 'ตารางแบบฟอร์ม',
            'form.create' => 'สร้างแบบฟอร์มใหม่',
            'form.edit' => 'แก้ไขแบบฟอร์ม',
            'importdata.index' => 'นำเข้าข้อมูล',
            'prefixes.index' => 'คำนำหน้า',
            'renewal_codes.index' => 'รหัสต่ออายุ',
            'renewal_codes.show' => 'รายละเอียดรหัสต่ออายุ',
            'tsms.index' => 'บัญชีผู้ใช้ TSM',
            'tsm.manage-org' => 'จัดการบริษัทที่รับผิดชอบ',
            'usermanual' => 'คู่มือการใช้งาน',
            'loginHistory' => 'ประวัติการเข้าใช้ระบบ',
        ];

        return $pageTitles[$routeName] ?? 'หน้าหลัก';
    }

    public static function getBreadcrumbItems($routeName = null)
    {
        $routeName = $routeName ?? request()->route()->getName();
        $items = [];

        $items[] = ['label' => 'หน้าหลัก', 'url' => route('home')];

        $breadcrumbMap = [
            'manage.data' => [
                ['label' => 'จัดการข้อมูล', 'url' => null],
            ],
            'posts.index' => [
                ['label' => 'โพส/ประกาศ', 'url' => null],
            ],
            'posts.create' => [
                ['label' => 'โพส/ประกาศ', 'url' => route('posts.index')],
                ['label' => 'สร้างโพสใหม่', 'url' => null],
            ],
            'posts.show' => [
                ['label' => 'โพส/ประกาศ', 'url' => route('posts.index')],
                ['label' => 'รายละเอียด', 'url' => null],
            ],
            'posts.edit' => [
                ['label' => 'โพส/ประกาศ', 'url' => route('posts.index')],
                ['label' => 'แก้ไข', 'url' => null],
            ],
            'document.fill-out.selectform' => [
                ['label' => 'ทำเอกสาร 5 หมวด', 'url' => null],
            ],
            'document.fill-out' => [
                ['label' => 'ทำเอกสาร 5 หมวด', 'url' => route('document.fill-out.selectform')],
                ['label' => 'กรอกเอกสาร', 'url' => null],
            ],
            'document.table.selectform' => [
                ['label' => 'ทะเบียนเอกสาร', 'url' => null],
            ],
            'document.table' => [
                ['label' => 'ทะเบียนเอกสาร', 'url' => route('document.table.selectform')],
                ['label' => 'ตาราง', 'url' => null],
            ],
            'document.submission.show' => [
                ['label' => 'ทะเบียนเอกสาร', 'url' => route('document.table.selectform')],
                ['label' => 'รายละเอียด', 'url' => null],
            ],
            'document.submission.edit' => [
                ['label' => 'ทะเบียนเอกสาร', 'url' => route('document.table.selectform')],
                ['label' => 'แก้ไข', 'url' => null],
            ],
            'document.export.filter' => [
                ['label' => 'ออกรายงาน', 'url' => null],
            ],
            'work-records.table' => [
                ['label' => 'ทะเบียนเวลาทำงาน', 'url' => null],
            ],
            'car.ma.table' => [
                ['label' => 'บันทึกการบำรุงรักษารถ', 'url' => null],
            ],
            'car.ma.form' => [
                ['label' => 'บันทึกการบำรุงรักษารถ', 'url' => route('car.ma.table')],
                ['label' => 'บันทึกใหม่', 'url' => null],
            ],
            'logbook.table' => [
                ['label' => 'Log Book', 'url' => null],
            ],
            'logbook.create' => [
                ['label' => 'Log Book', 'url' => route('logbook.table')],
                ['label' => 'สร้างใหม่', 'url' => null],
            ],
            'elearning' => [
                ['label' => 'ความรู้ออนไลน์', 'url' => null],
            ],
            'performance.report' => [
                ['label' => 'ออกรายงาน', 'url' => route('document.export.filter')],
                ['label' => 'รายงานผลส่งกรมฯ', 'url' => null],
            ],
            'submission.count' => [
                ['label' => 'ออกรายงาน', 'url' => route('document.export.filter')],
                ['label' => 'จำนวนการทำเอกสาร', 'url' => null],
            ],
            'users.index' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'บัญชีผู้ใช้', 'url' => null],
            ],
            'users.show' => [
                ['label' => 'บัญชีผู้ใช้', 'url' => route('users.index')],
                ['label' => 'รายละเอียด', 'url' => null],
            ],
            'users.create' => [
                ['label' => 'บัญชีผู้ใช้', 'url' => route('users.index')],
                ['label' => 'เพิ่มใหม่', 'url' => null],
            ],
            'users.edit' => [
                ['label' => 'บัญชีผู้ใช้', 'url' => route('users.index')],
                ['label' => 'แก้ไข', 'url' => null],
            ],
            'users.editByOwn' => [
                ['label' => 'แก้ไขโปรไฟล์', 'url' => null],
            ],
            'organizations.index' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'ข้อมูลบริษัท', 'url' => null],
            ],
            'organizations.show' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'ข้อมูลบริษัท', 'url' => route('organizations.index')],
                ['label' => 'รายละเอียด', 'url' => null],
            ],
            'positions.index' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'ตำแหน่ง', 'url' => null],
            ],
            'posit.perm' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'สิทธิ์การเข้าถึง', 'url' => null],
            ],
            'vehicles.index' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'ข้อมูลรถ', 'url' => null],
            ],
            'vehicles.show' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'ข้อมูลรถ', 'url' => route('vehicles.index')],
                ['label' => 'รายละเอียด', 'url' => null],
            ],
            'vehicle.assignment.table' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'จัดการผู้ประจำรถ', 'url' => null],
            ],
            'form.select-form-category' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'จัดการแบบฟอร์ม', 'url' => null],
            ],
            'importdata.index' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'นำเข้าข้อมูล', 'url' => null],
            ],
            'prefixes.index' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'คำนำหน้า', 'url' => null],
            ],
            'renewal_codes.index' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'รหัสต่ออายุ', 'url' => null],
            ],
            'tsms.index' => [
                ['label' => 'จัดการข้อมูล', 'url' => route('manage.data')],
                ['label' => 'บัญชีผู้ใช้ TSM', 'url' => null],
            ],
            'tsm.manage-org' => [
                ['label' => 'จัดการบริษัทที่รับผิดชอบ', 'url' => null],
            ],
            'usermanual' => [
                ['label' => 'คู่มือการใช้งาน', 'url' => null],
            ],
            'loginHistory' => [
                ['label' => 'ประวัติการเข้าใช้ระบบ', 'url' => null],
            ],
        ];

        if (isset($breadcrumbMap[$routeName])) {
            foreach ($breadcrumbMap[$routeName] as $item) {
                $items[] = $item;
            }
        } else {
            $items[] = ['label' => self::getPageTitle($routeName), 'url' => null];
        }

        return $items;
    }
}
