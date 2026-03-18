<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\User_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportDataController extends Controller
{
    public function index()
    {
        $previewData = session('previewData', []);
        $previewHeaders = session('previewHeaders', []);
        return view('organization.importData.importDataPage', compact('previewData', 'previewHeaders'));
    }

    public function saveImportedUsers(Request $request)
    {
        $previewData = session('previewData', []);

        if (empty($previewData)) {
            return redirect()->route('importdata.index')->with('error', 'ไม่มีข้อมูลให้นำเข้า กรุณาอัปโหลดไฟล์อีกครั้ง');
        }

        $errors = [];
        $successCount = 0;
        $currentUser = auth()->user();
        $defaultOrgId = $currentUser?->is_tsm ? session('connected_org') : ($currentUser?->userDetail->org ?? null);
        $defaultBranchId = $currentUser?->is_tsm ? null : ($currentUser?->userDetail->brn ?? null);

        foreach ($previewData as $index => $row) {
            $normalizedRow = [];
            foreach ($row as $key => $value) {
                if ($key === null) {
                    continue;
                }
                $normalizedKey = Str::slug((string) $key, '_');
                $normalizedRow[$normalizedKey] = is_string($value) ? trim($value) : $value;
            }

            $isEmptyRow = empty(array_filter($normalizedRow, fn ($value) => !is_null($value) && $value !== ''));
            if ($isEmptyRow) {
                continue;
            }

            $rowNumber = $index + 2; // account for header row in Excel

            $username = $normalizedRow['username'] ?? $normalizedRow['user_name'] ?? null;
            $password = $normalizedRow['password'] ?? $normalizedRow['pass'] ?? null;
            $prefixId = $normalizedRow['prefix_id'] ?? $normalizedRow['prefix'] ?? null;
            $firstName = $normalizedRow['first_name'] ?? $normalizedRow['fname'] ?? $normalizedRow['name'] ?? null;
            $lastName = $normalizedRow['last_name'] ?? $normalizedRow['lname'] ?? null;
            $citizenId = $normalizedRow['citizen_id'] ?? $normalizedRow['citizenid'] ?? $normalizedRow['national_id'] ?? null;
            $departmentId = $normalizedRow['department_id'] ?? $normalizedRow['department'] ?? null;
            $positionId = $normalizedRow['position_id'] ?? $normalizedRow['position'] ?? null;
            $plainEmail = $normalizedRow['email'] ?? null;

            $dpmData = $departmentId ? Department::with('getBrn')->find($departmentId) : null;
            $branchId = $dpmData?->brn_id ?? $defaultBranchId;
            $orgId = $dpmData?->getBrn?->org_id ?? $defaultOrgId;

            $requiredFields = [
                'username' => $username,
                'password' => $password,
                'prefix_id' => $prefixId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'department_id' => $departmentId,
                'position_id' => $positionId,
                'branch_id' => $branchId,
                'org_id' => $orgId,
            ];

            $missingFields = array_keys(array_filter($requiredFields, fn ($value) => blank($value)));

            if (!empty($missingFields)) {
                $errors[] = "แถวที่ {$rowNumber}: ข้อมูลจำเป็นไม่ครบถ้วน (" . implode(', ', $missingFields) . ')';
                continue;
            }

            if (User::where('username', $username)->exists()) {
                $errors[] = "แถวที่ {$rowNumber}: ชื่อผู้ใช้ {$username} ถูกใช้แล้ว";
                continue;
            }

            try {
                DB::transaction(function () use ($username, $password, $prefixId, $firstName, $lastName, $citizenId, $departmentId, $branchId, $positionId, $orgId, $plainEmail) {
                    $user = User::create([
                        'user_id' => Str::uuid(),
                        'username' => $username,
                        'password' => Hash::make($password),
                        'pass_text' => $password,
                        'email' => $plainEmail,
                    ]);

                    User_detail::create([
                        'user_id' => $user->id,
                        'prefix' => $prefixId,
                        'fname' => $firstName,
                        'lname' => $lastName,
                        'citizen_id' => $citizenId,
                        'dpm' => $departmentId,
                        'brn' => $branchId,
                        'org' => $orgId,
                        'position' => $positionId,
                    ]);
                });

                $successCount++;
            } catch (\Throwable $e) {
                $errors[] = "แถวที่ {$rowNumber}: " . $e->getMessage();
            }
        }

        session()->forget(['previewData', 'previewHeaders']);

        $redirect = redirect()->route('importdata.index');

        if (!empty($errors)) {
            $redirect = $redirect->with('import_errors', $errors);
        }

        if ($successCount > 0) {
            $redirect = $redirect->with('success', "บันทึกข้อมูลผู้ใช้สำเร็จ {$successCount} รายการ");
        } elseif (empty($errors)) {
            $redirect = $redirect->with('info', 'ไม่มีข้อมูลใหม่ให้บันทึก');
        }

        return $redirect;
    }
}
