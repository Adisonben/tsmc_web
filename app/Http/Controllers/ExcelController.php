<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmissions;
use App\Models\Organization;
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

        $submissions = $query->get();

        return $submissions;
    }

    private function handleHeaderColumns($sheet, $concatHeaderFields, $formFields)
    {
        $startHeaderRow = 3;
        $secondHeaderRow = $startHeaderRow + 1;

        $column_field_ids = [];
        // Set the header row
        $column = 'A'; // Start from column A
        $sheet->setCellValue($column . $startHeaderRow, 'ลำดับ'); // First column (Index)
        $sheet->mergeCells("{$column}{$startHeaderRow}:{$column}{$secondHeaderRow}");
        $column++;
        // $concatFields = array_merge($defaultFields, $vehicleFields, $userFields);
        // foreach ($concatFields as $field) {
        //     $sheet->setCellValue($column . '1', $field['label']); // Format the header (optional)
        //     $column++;
        // }
        $headerColumns = [];
        foreach ($concatHeaderFields as $fieldGroup) {
            foreach ($fieldGroup as $field) {
                if ($field['is_checked']) {
                    $sheet->setCellValue($column . $startHeaderRow, $field['label']);
                    $sheet->mergeCells("{$column}{$startHeaderRow}:{$column}{$secondHeaderRow}"); // Merge two rows for single fields
                    $column++;
                }
            }
        }
        // Handle Form Fields (with Subfields)
        foreach ($formFields as $field) {
            if ($field['type'] === 'subform' && !empty($field['subformfields'])) {
                $subfieldCount = count($field['subformfields']);
                $sheet->setCellValue($column . $startHeaderRow, $field['label']);
                $sheet->mergeCells("{$column}{$startHeaderRow}:" . chr(ord($column) + $subfieldCount - 1) . $startHeaderRow);
                $headerColumns[] = [$column, $subfieldCount]; // Store column range
                $column = chr(ord($column) + $subfieldCount);
                foreach ($field['subformfields'] as $subfield) {
                    $column_field_ids[] = $subfield['id'];
                }
            } else {
                $sheet->setCellValue($column . $startHeaderRow, $field['label']);
                $sheet->mergeCells("{$column}{$startHeaderRow}:{$column}{$secondHeaderRow}"); // Merge if no subfields
                $column_field_ids[] = $field['id'];
                $column++;
            }
        }

        $num_subform = 0;
        foreach ($formFields as $field) {
            if ($field['type'] === 'subform' && !empty($field['subformfields'])) {
                $sub_column = $headerColumns[$num_subform][0];
                foreach ($field['subformfields'] as $subfield) {
                    $sheet->setCellValue($sub_column . $secondHeaderRow, $subfield['label']);
                    $sub_column++;
                }
                $num_subform++;
            }
        }

        // 1. Define border style
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        // 2. Determine range (e.g., A3 to lastColumn4)
        $lastColumn = chr(ord($column) - 1); // $column was already incremented
        $headerRange = "A{$startHeaderRow}:{$lastColumn}{$secondHeaderRow}";

        // 3. Apply style
        $sheet->getStyle($headerRange)->applyFromArray($borderStyle);
        $sheet->getStyle($headerRange)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle($headerRange)->getFill()->getStartColor()->setARGB('cccccc'); // light gray



        return $column_field_ids;
    }

    private function handleDataRows($sheet, $submissions, $concatFields, $column_field_ids)
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

            $subData['fname'] = ($submission->getUser?->userDetail->getPrefix->name ?? '') . ($submission->getUser?->userDetail->fname ?? '');
            $subData['lname'] = $submission->getUser?->userDetail->lname ?? '-';
            $subData['citizen_id'] = $submission->getUser?->userDetail->citizen_id ?? '-';
            $normal_field_datas[$submission->id] = $subData;
        }

        // Fill data from the database into the Excel sheet
        $row = 5; // Start from row 4 to leave space for headers
        $count = 1; // Index counter

        foreach ($submissions as $submission) {
            $column = 'A';
            $sheet->setCellValue($column . $row, $count); // First column (Index)
            $sheet->getStyle($column . $row)->applyFromArray([
                'borders' => [
                    'left' => ['borderStyle' => Border::BORDER_THIN],
                    'right' => ['borderStyle' => Border::BORDER_THIN],
                ],
            ]);
            $column++;
            // normal data
            foreach ($concatFields as $field) {
                if ($field['is_checked']) {
                    $sheet->setCellValueExplicit($column . $row, $normal_field_datas[$submission->id][$field['name']], DataType::TYPE_STRING);
                    $sheet->getStyle($column . $row)->applyFromArray([
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
                $sheet->setCellValueExplicit($column . $row, optional($submission->getFieldValue($field_id))->value ?? '', DataType::TYPE_STRING);
                $sheet->getStyle($column . $row)->applyFromArray([
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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $org_id = Auth()->user()->is_tsm ? session('connected_org') : Auth()->user()->userDetail->org;
        $org_data = Organization::find($org_id);
        $form_data = Form::find($request->form_id);
        foreach (range('B', 'Z') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }


        // ✅ เพิ่มโลโก้
        $drawing = new Drawing();
        $drawing->setPath(public_path('images/icons/tsmc_logo.png')); // ใส่ path รูปโลโก้
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
        $sheet->setCellValue('B1', $org_data?->name ?? "Transport Safety Manager Communication (TSMC)"); // ใส่ชื่อระบบ
        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16);
        // จัดกลางทั้งแนวตั้งและแนวนอน
        // $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B1')->getAlignment()->setVertical('center');

        // ✅ เพิ่มชื่อเอกสาร
        $sheet->mergeCells('B2:H2'); // รวมเซลล์
        $sheet->setCellValue('B2', $form_data?->title ?? "รายงาน"); // ใส่ชื่อระบบ
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


        //  ----------------- Set the header row -----------------
        $column_field_ids = $this->handleHeaderColumns($sheet, $concatHeaderFields, $formFields);

        // Fetch data from the database
        $submissions = $this->fetchSubmissionData($request->form_id, $request->start_date, $request->end_date, $request->vehicle_id, $request->user_id);

        //  ----------------- Set the data rows -----------------
        $this->handleDataRows($sheet, $submissions, $concatFields, $column_field_ids);


        // Create a writer for Xlsx format
        $writer = new Xlsx($spreadsheet);

        // Set the filename and export the Excel file
        $filename = "TSMC_" . date('dmY_His') . '.xlsx';

        // Output to browser
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="' . $filename . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }
}
