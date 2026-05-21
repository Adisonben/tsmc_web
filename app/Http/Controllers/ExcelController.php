<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\ExportPerformanceReport;
use App\Models\Form;
use App\Models\Form_category;
use App\Models\FormSubmissions;
use App\Models\Organization;
use App\Models\Position;
use App\Models\Prefix;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    private function fetchSubmissionData($formId, $startDate, $endDate, $vehicleId, $userId)
    {
        $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
        $query = FormSubmissions::where('form_id', $formId)->where('org', $org_id ?? '');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $submissions = $query->orderBy('created_at', 'desc')->get();

        return $submissions;
    }

    public function setHeaderCellStyle($sheet, $headerRange)
    {
        $sheet->getStyle($headerRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($headerRange)->getFill()->getStartColor()->setARGB('cccccc'); // light gray
    }

    private function getExcelColumnName($index)
    {
        $columnName = '';
        while ($index >= 0) {
            $columnName = chr($index % 26 + 65).$columnName;
            $index = intval($index / 26) - 1;
        }

        return $columnName;
    }

    private function initSheetTitle($sheet, $org_data, $form_title)
    {
        // get org logo
        if ($org_data && $org_data->logo_img) {
            $logo_path = public_path('/uploads/orglogoes/'.$org_data->logo_img ?? '');
        } else {
            $logo_path = public_path('/images/icons/tsmc_logo.png');
        }

        // ✅ เพิ่มโลโก้
        $drawing = new Drawing;
        $drawing->setPath($logo_path); // ใส่ path รูปโลโก้
        $drawing->setHeight(60); // ปรับขนาดโลโก้
        $drawing->setCoordinates('A1'); // ตำแหน่งรูป
        $drawing->setWorksheet($sheet);
        $sheet->mergeCells('A1:A2');

        // ปรับความกว้างของคอลัมน์ A ให้พอดีกับรูป
        $sheet->getColumnDimension('A')->setWidth(15);
        // ปรับความสูงของแถว 1,2 เพื่อให้ภาพไม่ล้น
        $sheet->getRowDimension(1)->setRowHeight(30);

        // ✅ เพิ่มชื่อระบบ
        $sheet->mergeCells('B1:H1'); // รวมเซลล์
        $sheet->setCellValue('B1', $org_data?->name ?? 'Transport Safety Manager Communication (TSMC)'); // ใส่ชื่อระบบ
        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16);
        // จัดกลางทั้งแนวตั้งและแนวนอน
        // $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B1')->getAlignment()->setVertical('center');

        // ✅ เพิ่มชื่อเอกสาร
        $sheet->mergeCells('B2:H2'); // รวมเซลล์
        $sheet->setCellValue('B2', $form_title ?? 'รายงาน'); // ใส่ชื่อระบบ
        $sheet->getStyle('B2')->getFont()->setSize(14);
        // จัดกลางทั้งแนวตั้งและแนวนอน
        // $sheet->getStyle('B2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B2')->getAlignment()->setVertical('center');

        $sheet->getStyle('A1:H2')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle('A1:H2')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:H2')->getFill()->getStartColor()->setARGB('b3ffb8'); // light gray

        return $sheet;
    }

    private function handleHeaderColumns($sheet, $concatHeaderFields, $formFields, $startHeaderRow)
    {
        // $startHeaderRow = 3;
        $secondHeaderRow = $startHeaderRow + 1;

        $columnIndex = 0;
        $column_field_ids = [];

        $sheet->setCellValue($this->getExcelColumnName($columnIndex).$startHeaderRow, 'ลำดับ');
        $sheet->mergeCells($this->getExcelColumnName($columnIndex).$startHeaderRow.':'.$this->getExcelColumnName($columnIndex).$secondHeaderRow);
        $this->setHeaderCellStyle($sheet, $this->getExcelColumnName($columnIndex).$startHeaderRow.':'.$this->getExcelColumnName($columnIndex).$secondHeaderRow);
        $columnIndex++;

        // concatHeaderFields
        foreach ($concatHeaderFields as $fieldGroup) {
            foreach ($fieldGroup as $field) {
                if ($field['is_checked']) {
                    $colName = $this->getExcelColumnName($columnIndex);
                    $sheet->setCellValue($colName.$startHeaderRow, $field['label']);
                    $sheet->mergeCells("{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
                    $this->setHeaderCellStyle($sheet, "{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
                    $columnIndex++;
                }
            }
        }

        // formFields
        $headerColumns = [];
        foreach ($formFields as $field) {
            $colName = $this->getExcelColumnName($columnIndex);

            if ($field['type'] === 'subform' && ! empty($field['subformfields'])) {
                $subfieldCount = count($field['subformfields']);
                $endColName = $this->getExcelColumnName($columnIndex + $subfieldCount - 1);

                $sheet->setCellValue($colName.$startHeaderRow, $field['label']);
                $sheet->mergeCells("{$colName}{$startHeaderRow}:{$endColName}{$startHeaderRow}");
                $this->setHeaderCellStyle($sheet, "{$colName}{$startHeaderRow}:{$endColName}{$startHeaderRow}");
                $headerColumns[] = [$columnIndex, $subfieldCount];

                foreach ($field['subformfields'] as $subfield) {
                    $column_field_ids[] = $subfield['id'];
                }

                $columnIndex += $subfieldCount;
            } else {
                $sheet->setCellValue($colName.$startHeaderRow, $field['label']);
                $sheet->mergeCells("{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
                $this->setHeaderCellStyle($sheet, "{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
                $column_field_ids[] = $field['id'];
                $columnIndex++;
            }
        }

        // second row of subfields
        $num_subform = 0;
        foreach ($formFields as $field) {
            if ($field['type'] === 'subform' && ! empty($field['subformfields'])) {
                $startIndex = $headerColumns[$num_subform][0];
                foreach ($field['subformfields'] as $i => $subfield) {
                    $colName = $this->getExcelColumnName($startIndex + $i);
                    $sheet->setCellValue($colName.$secondHeaderRow, $subfield['label']);
                    $this->setHeaderCellStyle($sheet, $colName.$secondHeaderRow);
                }
                $num_subform++;
            }
        }

        return $column_field_ids;
    }

    private function handleDataRows($sheet, $submissions, $concatFields, $column_field_ids, $startDataRow)
    {
        $normal_field_datas = [];
        foreach ($submissions ?? [] as $key => $submission) {
            $subData = [];
            $subData['id'] = $submission->id;
            $subData['created_at'] = Carbon::parse($submission->created_at)->thaidate('j/m/Y');
            $subData['license_plate'] = $submission->getVehicle?->license_plate ?? '-';
            $subData['brand'] = $submission->getVehicle?->brand ?? '-';
            $subData['license_category'] = $submission->getVehicle?->license_category ?? '-';
            $subData['registration_province'] = $submission->getVehicle?->registration_province ?? '-';
            $subData['standard'] = $submission->getVehicle?->standard ?? '-';
            $subData['type'] = $submission->getVehicle?->type ?? '-';
            $subData['ins_company'] = $submission->getVehicle?->ins_company ?? '-';
            $subData['ins_type'] = $submission->getVehicle?->ins_type ?? '-';

            $subData['fname'] = ($submission->getUser?->userDetail->getPrefix->name ?? '').($submission->getUser?->userDetail->fname ?? '');
            $subData['lname'] = $submission->getUser?->userDetail->lname ?? '-';
            $subData['citizen_id'] = $submission->getUser?->userDetail->citizen_id ?? '-';
            $normal_field_datas[$submission->id] = $subData;
        }

        // Fill data from the database into the Excel sheet
        $row = $startDataRow; // Start from row 4 to leave space for headers
        $count = 1; // Index counter

        foreach ($submissions as $submission) {
            $column = 'A';
            $sheet->setCellValue($column.$row, $count); // First column (Index)
            $sheet->getStyle($column.$row)->applyFromArray([
                'borders' => [
                    'left' => ['borderStyle' => Border::BORDER_THIN],
                    'right' => ['borderStyle' => Border::BORDER_THIN],
                ],
            ]);
            $column++;
            // normal data
            foreach ($concatFields as $field) {
                if ($field['is_checked']) {
                    $sheet->setCellValueExplicit($column.$row, $normal_field_datas[$submission->id][$field['name']], DataType::TYPE_STRING);
                    $sheet->getStyle($column.$row)->applyFromArray([
                        'borders' => [
                            'left' => ['borderStyle' => Border::BORDER_THIN],
                            'right' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);
                    $column++;
                }
            }

            // form data
            foreach ($column_field_ids as $field_id) {
                $sheet->setCellValueExplicit($column.$row, optional($submission->getFieldValue($field_id))->value ?? '', DataType::TYPE_STRING);
                $sheet->getStyle($column.$row)->applyFromArray([
                    'borders' => [
                        'left' => ['borderStyle' => Border::BORDER_THIN],
                        'right' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);
                $column++;
            }

            $row++;
            $count++;
        }

        // form data
    }

    /**
     * Get column configuration for a specific form.
     * Supports a unified order of concat fields (by name) and form fields (by id).
     */
    private function getColumnConfig($formId)
    {
        $configs = [
            // 1) Configuration for Form ID 1: Includes all fields, with form field 12 placed before citizen_id
            5 => [
                'column_order' => [
                    ['type' => 'concat', 'name' => 'created_at'],
                    ['type' => 'concat', 'name' => 'license_category'],
                    ['type' => 'concat', 'name' => 'license_plate'],
                    ['type' => 'concat', 'name' => 'registration_province'],
                    ['type' => 'concat', 'name' => 'brand'],
                    ['type' => 'concat', 'name' => 'standard'],
                    ['type' => 'concat', 'name' => 'type'],
                    ['type' => 'concat', 'name' => 'ins_company'],
                    ['type' => 'concat', 'name' => 'ins_type'],
                    ['type' => 'concat', 'name' => 'fname'],
                    ['type' => 'concat', 'name' => 'lname'],
                    ['type' => 'form',   'id' => 12], // Form field 12 placed before citizen_id
                    ['type' => 'concat', 'name' => 'citizen_id'],
                    ['type' => 'form',   'id' => 13],
                    ['type' => 'form',   'id' => 14],
                ],
            ],
            // 2) Configuration for Form ID 2: Excludes 2 fields (brand and form field 14 are omitted)
            6 => [
                'column_order' => [
                    ['type' => 'concat', 'name' => 'created_at'],
                    ['type' => 'concat', 'name' => 'license_category'],
                    ['type' => 'concat', 'name' => 'license_plate'],
                    ['type' => 'concat', 'name' => 'registration_province'],
                    // 'brand' is excluded here
                    ['type' => 'concat', 'name' => 'standard'],
                    ['type' => 'concat', 'name' => 'type'],
                    ['type' => 'concat', 'name' => 'ins_company'],
                    ['type' => 'concat', 'name' => 'ins_type'],
                    ['type' => 'concat', 'name' => 'fname'],
                    ['type' => 'concat', 'name' => 'lname'],
                    ['type' => 'form',   'id' => 12],
                    ['type' => 'concat', 'name' => 'citizen_id'],
                    ['type' => 'form',   'id' => 13],
                    // Form field 14 is excluded here
                ],
            ],
        ];

        return $configs[$formId] ?? [];
    }

    /**
     * Build a unified columns list from config, active concat fields, and form fields.
     */
    private function buildUnifiedColumns(array $config, array $concatFields, array $formFields)
    {
        // Only keep concat fields that are checked
        $activeConcatFields = array_filter($concatFields, function ($field) {
            return ! empty($field['is_checked']);
        });

        // Key by name for easy lookup
        $concatLookup = [];
        foreach ($activeConcatFields as $field) {
            $concatLookup[$field['name']] = $field;
        }

        // Key by id for easy lookup
        $formLookup = [];
        foreach ($formFields as $field) {
            $formLookup[$field['id']] = $field;
        }

        if (empty($config) || empty($config['column_order'])) {
            // Default order: all active concat fields, then all form fields
            $unified = [];
            foreach ($activeConcatFields as $field) {
                $unified[] = array_merge($field, ['unified_type' => 'concat']);
            }
            foreach ($formFields as $field) {
                $unified[] = array_merge($field, ['unified_type' => 'form']);
            }

            return $unified;
        }

        $unified = [];
        foreach ($config['column_order'] as $item) {
            if ($item['type'] === 'concat') {
                if (isset($concatLookup[$item['name']])) {
                    $unified[] = array_merge($concatLookup[$item['name']], ['unified_type' => 'concat']);
                }
            } elseif ($item['type'] === 'form') {
                if (isset($formLookup[$item['id']])) {
                    $unified[] = array_merge($formLookup[$item['id']], ['unified_type' => 'form']);
                }
            }
        }

        return $unified;
    }

    /**
     * Write headers dynamically from the unified columns list.
     */
    private function writeUnifiedHeaders($sheet, array $unifiedColumns, int $startHeaderRow)
    {
        $secondHeaderRow = $startHeaderRow + 1;
        $columnIndex = 0;

        // Column 0: ลำดับ
        $colName = $this->getExcelColumnName($columnIndex);
        $sheet->setCellValue($colName.$startHeaderRow, 'ลำดับ');
        $sheet->mergeCells("{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
        $this->setHeaderCellStyle($sheet, "{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
        $columnIndex++;

        foreach ($unifiedColumns as $column) {
            $colName = $this->getExcelColumnName($columnIndex);

            if ($column['unified_type'] === 'concat') {
                $sheet->setCellValue($colName.$startHeaderRow, $column['label']);
                $sheet->mergeCells("{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
                $this->setHeaderCellStyle($sheet, "{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
                $columnIndex++;
            } elseif ($column['unified_type'] === 'form') {
                if ($column['type'] === 'subform' && ! empty($column['subformfields'])) {
                    $subfieldCount = count($column['subformfields']);
                    $endColName = $this->getExcelColumnName($columnIndex + $subfieldCount - 1);

                    $sheet->setCellValue($colName.$startHeaderRow, $column['label']);
                    $sheet->mergeCells("{$colName}{$startHeaderRow}:{$endColName}{$startHeaderRow}");
                    $this->setHeaderCellStyle($sheet, "{$colName}{$startHeaderRow}:{$endColName}{$startHeaderRow}");

                    foreach ($column['subformfields'] as $i => $subfield) {
                        $subColName = $this->getExcelColumnName($columnIndex + $i);
                        $sheet->setCellValue($subColName.$secondHeaderRow, $subfield['label']);
                        $this->setHeaderCellStyle($sheet, $subColName.$secondHeaderRow);
                    }

                    $columnIndex += $subfieldCount;
                } else {
                    $sheet->setCellValue($colName.$startHeaderRow, $column['label']);
                    $sheet->mergeCells("{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
                    $this->setHeaderCellStyle($sheet, "{$colName}{$startHeaderRow}:{$colName}{$secondHeaderRow}");
                    $columnIndex++;
                }
            }
        }
    }

    /**
     * Write data rows dynamically in the exact order of the unified columns list.
     */
    private function writeUnifiedDataRows($sheet, $submissions, array $unifiedColumns, int $startDataRow)
    {
        $normal_field_datas = [];
        foreach ($submissions ?? [] as $key => $submission) {
            $subData = [];
            $subData['id'] = $submission->id;
            $subData['created_at'] = Carbon::parse($submission->created_at)->thaidate('j/m/Y');
            $subData['license_plate'] = $submission->getVehicle?->license_plate ?? '-';
            $subData['brand'] = $submission->getVehicle?->brand ?? '-';
            $subData['license_category'] = $submission->getVehicle?->license_category ?? '-';
            $subData['registration_province'] = $submission->getVehicle?->registration_province ?? '-';
            $subData['standard'] = $submission->getVehicle?->standard ?? '-';
            $subData['type'] = $submission->getVehicle?->type ?? '-';
            $subData['ins_company'] = $submission->getVehicle?->ins_company ?? '-';
            $subData['ins_type'] = $submission->getVehicle?->ins_type ?? '-';

            $subData['fname'] = ($submission->getUser?->userDetail->getPrefix->name ?? '').($submission->getUser?->userDetail->fname ?? '');
            $subData['lname'] = $submission->getUser?->userDetail->lname ?? '-';
            $subData['citizen_id'] = $submission->getUser?->userDetail->citizen_id ?? '-';
            $normal_field_datas[$submission->id] = $subData;
        }

        $row = $startDataRow;
        $count = 1;

        foreach ($submissions as $submission) {
            $columnIndex = 0;
            $colName = $this->getExcelColumnName($columnIndex);

            // Column 0: ลำดับ
            $sheet->setCellValue($colName.$row, $count);
            $sheet->getStyle($colName.$row)->applyFromArray([
                'borders' => [
                    'left' => ['borderStyle' => Border::BORDER_THIN],
                    'right' => ['borderStyle' => Border::BORDER_THIN],
                ],
            ]);
            $columnIndex++;

            foreach ($unifiedColumns as $column) {
                if ($column['unified_type'] === 'concat') {
                    $cellColName = $this->getExcelColumnName($columnIndex);
                    $val = $normal_field_datas[$submission->id][$column['name']] ?? '';
                    $sheet->setCellValueExplicit($cellColName.$row, $val, DataType::TYPE_STRING);
                    $sheet->getStyle($cellColName.$row)->applyFromArray([
                        'borders' => [
                            'left' => ['borderStyle' => Border::BORDER_THIN],
                            'right' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);
                    $columnIndex++;
                } elseif ($column['unified_type'] === 'form') {
                    if ($column['type'] === 'subform' && ! empty($column['subformfields'])) {
                        foreach ($column['subformfields'] as $subfield) {
                            $cellColName = $this->getExcelColumnName($columnIndex);
                            $val = optional($submission->getFieldValue($subfield['id']))->value ?? '';
                            $sheet->setCellValueExplicit($cellColName.$row, $val, DataType::TYPE_STRING);
                            $sheet->getStyle($cellColName.$row)->applyFromArray([
                                'borders' => [
                                    'left' => ['borderStyle' => Border::BORDER_THIN],
                                    'right' => ['borderStyle' => Border::BORDER_THIN],
                                ],
                            ]);
                            $columnIndex++;
                        }
                    } else {
                        $cellColName = $this->getExcelColumnName($columnIndex);
                        $val = optional($submission->getFieldValue($column['id']))->value ?? '';
                        $sheet->setCellValueExplicit($cellColName.$row, $val, DataType::TYPE_STRING);
                        $sheet->getStyle($cellColName.$row)->applyFromArray([
                            'borders' => [
                                'left' => ['borderStyle' => Border::BORDER_THIN],
                                'right' => ['borderStyle' => Border::BORDER_THIN],
                            ],
                        ]);
                        $columnIndex++;
                    }
                }
            }

            $row++;
            $count++;
        }
    }

    public function export(Request $request)
    {
        // get fields
        $defaultFields = json_decode($request->default_fields, true);
        $vehicleFields = json_decode($request->vehicle_fields, true);
        $userFields = json_decode($request->user_fields, true);
        $formFields = json_decode($request->form_fields, true);
        $concatHeaderFields = [$defaultFields, $vehicleFields, $userFields];
        $concatFields = array_merge($defaultFields, $vehicleFields, $userFields);

        // Initialize the Spreadsheet object
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
        $org_data = Organization::find($org_id);
        $form_data = Form::find($request->form_id);
        foreach (range('B', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet = $this->initSheetTitle($sheet, $org_data, $form_data?->title);

        //  ----------------- Set the header row -----------------
        $column_field_ids = $this->handleHeaderColumns($sheet, $concatHeaderFields, $formFields, 3);

        // Fetch data from the database
        $submissions = $this->fetchSubmissionData($request->form_id, $request->start_date, $request->end_date, $request->vehicle_id, $request->user_id);

        //  ----------------- Set the data rows -----------------
        $this->handleDataRows($sheet, $submissions, $concatFields, $column_field_ids, 5);

        // Create a writer for Xlsx format
        $writer = new Xlsx($spreadsheet);

        // Set the filename and export the Excel file
        $filename = 'TSMC_'.date('dmY_His').'.xlsx';

        // Output to browser
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="'.$filename.'"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    public function performanceReport(Request $request)
    {
        $quarter = $request->quarter ?? Carbon::now()->quarterOfYear();
        $categories = Form_category::all();

        return view('exportDocument.performanceReport', compact('categories', 'quarter'));
    }

    public function submissionCount(Request $request)
    {
        $quarter = $request->quarter ?? Carbon::now()->quarterOfYear();
        $categories = Form_category::all();

        return view('exportDocument.submissionCount', compact('categories', 'quarter'));
    }

    public function downloadUserTemplate()
    {
        $spreadsheet = new Spreadsheet;

        // --- User data sheet ---
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Users');

        $headers = ['id', 'username', 'password', 'citizen_id', 'prefix_id', 'first_name', 'last_name', 'department_id', 'position_id'];

        foreach ($headers as $index => $header) {
            $col = $this->getExcelColumnName($index);
            $sheet->setCellValue($col.'1', $header);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $lastCol = $this->getExcelColumnName(count($headers) - 1);
        $this->setHeaderCellStyle($sheet, 'A1:'.$lastCol.'1');

        $orgId = Auth()->user()->is_tsm ? session('connected_org') : (Auth()->user()->userDetail->org ?? null);

        // --- Department sheet ---
        $departmentSheet = $spreadsheet->createSheet();
        $departmentSheet->setTitle('Department');
        $departmentSheet->setCellValue('A1', 'id');
        $departmentSheet->setCellValue('B1', 'name');
        $departmentSheet->getColumnDimension('A')->setAutoSize(true);
        $departmentSheet->getColumnDimension('B')->setAutoSize(true);
        $this->setHeaderCellStyle($departmentSheet, 'A1:B1');

        $departmentQuery = Department::query()->select(['id', 'name'])->orderBy('name');
        if ($orgId) {
            $departmentQuery->whereHas('getBrn', function ($query) use ($orgId) {
                $query->where('org_id', $orgId);
            });
        }
        $departments = $departmentQuery->get();

        foreach ($departments as $index => $department) {
            $row = $index + 2;
            $departmentSheet->setCellValue('A'.$row, $department->id);
            $departmentSheet->setCellValue('B'.$row, $department->name);
        }

        // --- Position sheet ---
        $positionSheet = $spreadsheet->createSheet();
        $positionSheet->setTitle('Position');
        $positionSheet->setCellValue('A1', 'id');
        $positionSheet->setCellValue('B1', 'name');
        $positionSheet->getColumnDimension('A')->setAutoSize(true);
        $positionSheet->getColumnDimension('B')->setAutoSize(true);
        $this->setHeaderCellStyle($positionSheet, 'A1:B1');

        $positionQuery = Position::query()->select(['id', 'name'])->orderBy('name');
        if ($orgId) {
            $positionQuery->where(function ($query) use ($orgId) {
                $query->where('org', $orgId)->orWhereNull('org');
            });
        }
        $positions = $positionQuery->get();

        foreach ($positions as $index => $position) {
            $row = $index + 2;
            $positionSheet->setCellValue('A'.$row, $position->id);
            $positionSheet->setCellValue('B'.$row, $position->name);
        }

        // --- Prefix sheet ---
        $prefixSheet = $spreadsheet->createSheet();
        $prefixSheet->setTitle('Prefix');
        $prefixSheet->setCellValue('A1', 'id');
        $prefixSheet->setCellValue('B1', 'name');
        $prefixSheet->getColumnDimension('A')->setAutoSize(true);
        $prefixSheet->getColumnDimension('B')->setAutoSize(true);
        $this->setHeaderCellStyle($prefixSheet, 'A1:B1');

        $prefixes = Prefix::select(['id', 'name'])->orderBy('name')->get();

        foreach ($prefixes as $index => $prefix) {
            $row = $index + 2;
            $prefixSheet->setCellValue('A'.$row, $prefix->id);
            $prefixSheet->setCellValue('B'.$row, $prefix->name);
        }

        // make sure user sheet is active when opening
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $filename = 'TSMC_user_template_'.date('dmY_His').'.xlsx';

        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="'.$filename.'"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    public function previewImportUsers(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('import_file');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $headers = [];
        $previewData = [];

        foreach ($rows as $rowIndex => $row) {
            if ($rowIndex === 1) {
                $headers = array_values($row);

                continue;
            }
            $rowData = [];
            foreach (array_values($row) as $i => $value) {
                $rowData[$headers[$i] ?? $i] = $value;
            }
            $previewData[] = $rowData;
        }

        session([
            'previewData' => $previewData,
            'previewHeaders' => $headers,
        ]);

        return redirect()->route('importdata.index')->with('success', 'นำเข้าไฟล์สำเร็จ');
    }

    public function exportPerformanceReport(Request $request)
    {

        // Initialize the Spreadsheet object
        $quarter = $request->quarter;
        $form_id = $request->form_id;
        $quarter_start_date = now()->startOfYear()->addMonths(($quarter - 1) * 3);
        $quarter_end_date = now()->startOfYear()->addMonths((($quarter - 1) * 3) + 3)->subDay();

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
        $org_data = Organization::find($org_id);

        $form_data = Form::where('id', $form_id)->where(function ($query) {
            $query->where('org', $org_id ?? '')
                ->orWhere('created_by', Auth::user()->id)
                ->orWhere('is_default', true);
        })->select(['id', 'title', 'select_user', 'select_vehicle'])->first();

        // set form column
        $formFields = [];
        foreach ($form_data->formFields as $key => $field) {
            if ($field->type === 'subform') {
                $subFormFields = [];
                foreach ($field->subform->subformfields as $subField) {
                    $subFormFields[] = [
                        'id' => $subField->id,
                        'label' => $subField->label,
                    ];
                }

                $formFields[] = [
                    'id' => $field->id,
                    'label' => $field->label,
                    'type' => $field->type,
                    'subformfields' => $subFormFields,
                ];
            } else {
                $formFields[] = [
                    'id' => $field->id,
                    'label' => $field->label,
                    'type' => $field->type,
                    'subformfields' => [],
                ];
            }
        }

        dd($formFields);

        $defaultFields = [
            [
                'name' => 'created_at',
                'label' => 'วันที่',
                'is_checked' => true,
            ],
        ];
        $vehicleFields =
        [
            [
                'name' => 'license_category',
                'label' => 'หมวดทะเบียนรถ',
                'is_checked' => $form_data?->select_vehicle ?? false,
            ],
            [
                'name' => 'license_plate',
                'label' => 'เลขทะเบียนรถ',
                'is_checked' => $form_data?->select_vehicle ?? false,
            ],
            [
                'name' => 'registration_province',
                'label' => 'จังหวัดที่จดทะเบียน',
                'is_checked' => $form_data?->select_vehicle ?? false,
            ],
            [
                'name' => 'brand',
                'label' => 'ยี่ห้อ',
                'is_checked' => $form_data?->select_vehicle ?? false,
            ],
            [
                'name' => 'standard',
                'label' => 'ลักษณะ/มาตรฐาน',
                'is_checked' => $form_data?->select_vehicle ?? false,
            ],
            [
                'name' => 'type',
                'label' => 'ประเภทของรถ',
                'is_checked' => $form_data?->select_vehicle ?? false,
            ],
            [
                'name' => 'ins_company',
                'label' => 'บริษัทประกันภัย',
                'is_checked' => $form_data?->select_vehicle ?? false,
            ],
            [
                'name' => 'ins_type',
                'label' => 'ประเภทประกันภัย',
                'is_checked' => $form_data?->select_vehicle ?? false,
            ],
        ];

        $userFields =
        [
            [
                'name' => 'fname',
                'label' => 'ชื่อพนักงาน',
                'is_checked' => $form_data?->select_user ?? false,
            ],
            [
                'name' => 'lname',
                'label' => 'นามสกุล',
                'is_checked' => $form_data?->select_user ?? false,
            ],
            [
                'name' => 'citizen_id',
                'label' => 'เลขประจำตัวประชาชน',
                'is_checked' => $form_data?->select_user ?? false,
            ],
        ];

        $allConcatFields = array_merge($defaultFields, $vehicleFields, $userFields);

        // Apply column config (exclude/reorder/unify) per form
        $columnConfig = $this->getColumnConfig($form_id);
        $unifiedColumns = $this->buildUnifiedColumns($columnConfig, $allConcatFields, $formFields);

        // set sheet title
        foreach (range('B', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // $sheet = $this->initSheetTitle($sheet, $org_data, $form_data?->title);

        //  ----------------- Set the header row -----------------
        $this->writeUnifiedHeaders($sheet, $unifiedColumns, 1);

        // Fetch data from the database
        $submissions = $this->fetchSubmissionData($form_id, $quarter_start_date, $quarter_end_date, null, null);

        //  ----------------- Set the data rows -----------------
        $this->writeUnifiedDataRows($sheet, $submissions, $unifiedColumns, 3);

        // Create a writer for Xlsx format
        $writer = new Xlsx($spreadsheet);

        // Set the filename and export the Excel file
        $filename = 'TSMC_'.date('dmY_His').'.xlsx';

        ExportPerformanceReport::create([
            'user_id' => Auth::user()->id,
            'form_id' => $form_id,
            'quarter' => $quarter,
            'org' => $org_id,
        ]);

        // Output to browser
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="'.$filename.'"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}
