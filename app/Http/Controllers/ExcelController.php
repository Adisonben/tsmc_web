<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmissions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    private function fetchSubmissionData($formId, $startDate, $endDate, $vehicleId, $userId)
    {
        $query = FormSubmissions::where('form_id', $formId)->where('org', Auth::user()->userDetail->org ?? '');

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

    private function handleHeaderColumns($sheet, $concatHeaderFields, $formFields) {
        $column_field_ids = [];
        // Set the header row
        $column = 'A'; // Start from column A
        $sheet->setCellValue($column . '1', 'ลำดับ'); // First column (Index)
        $sheet->mergeCells("{$column}1:{$column}2");
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
                    $sheet->setCellValue($column . '1', $field['label']);
                    $sheet->mergeCells("{$column}1:{$column}2"); // Merge two rows for single fields
                    $column++;
                }
            }
        }
        // Handle Form Fields (with Subfields)
        foreach ($formFields as $field) {
            if ($field['type'] === 'subform' && !empty($field['subformfields'])) {
                $subfieldCount = count($field['subformfields']);
                $sheet->setCellValue($column . '1', $field['label']);
                $sheet->mergeCells("{$column}1:" . chr(ord($column) + $subfieldCount - 1) . "1");
                $headerColumns[] = [$column, $subfieldCount]; // Store column range
                $column = chr(ord($column) + $subfieldCount);
                foreach ($field['subformfields'] as $subfield) {
                    $column_field_ids[] = $subfield['id'];
                }
            } else {
                $sheet->setCellValue($column . '1', $field['label']);
                $sheet->mergeCells("{$column}1:{$column}2"); // Merge if no subfields
                $column_field_ids[] = $field['id'];
                $column++;
            }
        }

        $num_subform = 0;
        foreach ($formFields as $field) {
            if ($field['type'] === 'subform' && !empty($field['subformfields'])) {
                $sub_column = $headerColumns[$num_subform][0];
                foreach ($field['subformfields'] as $subfield) {
                    $sheet->setCellValue($sub_column . '2', $subfield['label']);
                    $sub_column++;
                }
                $num_subform++;
            }
        }

        return $column_field_ids;
    }

    private function handleDataRows($sheet, $submissions, $concatFields, $column_field_ids) {
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
        $row = 3; // Start from row 2 to leave space for headers
        $count = 1; // Index counter

        foreach ($submissions as $submission) {
            $column = 'A';
            $sheet->setCellValue($column . $row, $count); // First column (Index)
            $column++;
            // normal data
            foreach ($concatFields as $field) {
                if ($field['is_checked']) {
                    $sheet->setCellValueExplicit($column . $row, $normal_field_datas[$submission->id][$field['name']], DataType::TYPE_STRING);
                    $column++;
                }
            }

            // form data
            foreach ($column_field_ids as $field_id) {
                $sheet->setCellValueExplicit($column . $row, optional($submission->getFieldValue($field_id))->value ?? '', DataType::TYPE_STRING);
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
