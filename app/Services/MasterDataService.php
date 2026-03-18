<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Branch;
use App\Models\Form;
use App\Models\Position;
use App\Models\Position_has_permission;
use App\Models\Position_permission;
use App\Models\PositionHasForm;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MasterDataService
{
    private array $starterDepartmentList = 
    [
        [
            'name' => 'แผนกบริหารและกลยุทธ์ (Management & Strategy)',
            'position' => [
                [
                    'name' => 'ผู้ประกอบการ/เจ้าของกิจการ',
                    'form' => ['5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15'],
                    'perm' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                ]
            ]
        ],
        [
            'name' => 'แผนกปฏิบัติการขนส่ง (Operations & Fleet Management)',
            'position' => [
                [
                    'name' => 'หัวหน้าพนักงานขับรถ (Driver Supervisor)',
                    'form' => ['5', '6', '7', '8', '9', '10', '11', '12', '13', '14'],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ],
                [
                    'name' => 'พนักงานขับรถ (Driver)',
                    'form' => ['5', '6'],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ],
                [
                    'name' => 'ผู้จัดการกองรถ  (Fleet Manager)',
                    'form' => ['5', '6', '8', '9', '10', '11', '12', '13', '14', '15'],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ],
                [
                    'name' => 'เจ้าหน้าที่จัดเดินรถ (Dispatcher)',
                    'form' => ['5', '6', '8', '9', '10', '11', '15'],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ],
                [
                    'name' => 'นักวางแผนโลจิสติกส์ (Logistics Planner)',
                    'form' => ['14',],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ]
            ]
        ],
        [
            'name' => 'แผนกซ่อมบำรุง (Maintenance Department)',
            'position' => [
                [
                    'name' => 'หัวหน้าช่างซ่อมบำรุง (Maintenance Supervisor)',
                    'form' => ['7'],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ],
                [
                    'name' => 'ช่างซ่อมบำรุง (Maintenance Engineer)',
                    'form' => [],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ]
            ]
        ],
        [
            'name' => 'แผนกความปลอดภัยและอาชีวอนามัย (Safety & QHSE)',
            'position' => [
                [
                    'name' => 'TSM ( Transport Safety Manager)',
                    'form' => ['5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15'],
                    'perm' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                ]
            ]
        ],
        [
            'name' => 'แผนกสนับสนุนและทรัพยากรบุคคล (Admin & HR)',
            'position' => [
                [
                    'name' => 'ฝ่ายธุรการ (Administrative Officer)',
                    'form' => ['7', '8', '9', '10', '11', '12', '13'],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ],
                [
                    'name' => 'ฝ่ายบุคคล (HR Officer)',
                    'form' => ['8', '9', '10', '11', '12', '13'],
                    'perm' => ['1', '2', '3', '10', '11', '12'],
                ]
            ]
        ],
        
    ];

    public function generate(int $orgId, int $userId): array
    {
        return DB::transaction(function () use ($orgId, $userId) {

            $newBranch = Branch::create([
                'brn_id' => Str::uuid(),
                'name'=> 'สำนักงานใหญ่',
                'org_id' => $orgId,
            ]);

            $dpm_id = null;
            $pos_id = null;

            foreach ($this->starterDepartmentList as $dpmData) {

                $newDpm = Department::create([
                    'dpm_id' => Str::uuid(),
                    'name'=> $dpmData['name'],
                    'brn_id' => $newBranch->id,
                ]);

                if ($dpmData['name'] === 'แผนกบริหารและกลยุทธ์ (Management & Strategy)') {
                    $dpm_id = $newDpm->id;
                }

                foreach ($dpmData['position'] as $positionData) {

                    $newPosition = Position::create([
                        'name' => $positionData['name'],
                        'created_by' => $userId,
                        'org' => $orgId,
                    ]);

                    if ($positionData['name'] === 'ผู้ประกอบการ/เจ้าของกิจการ') {
                        $pos_id = $newPosition->id;
                    }

                    // 🔹 bulk insert (better performance)
                    $formData = [];
                    foreach ($positionData['form'] as $formId) {
                        if ($formId && Form::find($formId)) {
                            $formData[] = [
                                'position_id' => $newPosition->id,
                                'form_id' => $formId,
                            ];
                        }
                    }
                    if (!empty($formData)) {
                        PositionHasForm::insert($formData);
                    }

                    $permData = [];
                    foreach ($positionData['perm'] as $permId) {
                        if ($permId && Position_permission::find($permId)) {
                            $permData[] = [
                                'position_id' => $newPosition->id,
                                'permission_id' => $permId,
                                'user_id' => $userId,
                                'org' => $orgId,
                                'status' => true
                            ];
                        }
                    }
                    if (!empty($permData)) {
                        Position_has_permission::insert($permData);
                    }
                }
            }

            return [
                'brn_id' => $newBranch->id,
                'dpm_id' => $dpm_id,
                'pos_id' => $pos_id,
            ];
        });
    }
}