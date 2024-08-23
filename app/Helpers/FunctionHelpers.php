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
}
