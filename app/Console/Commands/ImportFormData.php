<?php

namespace App\Console\Commands;

use App\Models\FormSubmissions;
use App\Models\FormSubmissionValue;
use App\Models\User_detail;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportFormData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-form-data {org_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import form data from excel file to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orgId = $this->argument('org_id'); //493
        $this->info("Starting import for org_id: {$orgId}");

        $data = $this->readExcelFile();
        
        $this->info("Excel data parsed successfully!");
        $this->info("Total rows: " . count($data));

        $this->storeData($data, $orgId);
        
    }

    private $formfields = [
        21 => 11,
        22 => 12,
        23 => 13,
        24 => 14,
        25 => 15,
        26 => 16,
        1 => 17,
        2 => 18,
        3 => 19,
        4 => 20,
        5 => 21,
        6 => 22,
        28 => 23,
        29 => 24,
        30 => 25,
    ];

    private function storeData($data, $orgId)
    {
        $this->info("Starting to process data...");

        try {
            DB::beginTransaction();

            $successCount = 0;
            $skipCount = 0;

            foreach ($data as $key => $row) {
                $vehicles = Vehicle::where('license_category', $row[2])->where('license_plate', $row[3])->first();
                $users = User_detail::where('citizen_id', $row[10])->first();

                if (!$vehicles || !$users) {
                    $this->info("Vehicle: " . $row[2] . " " . $row[3] . " User: " . $row[10] . " - Not found in database");
                    $skipCount++;
                } else {
                    // Parse date from Excel
                    $dateValue = $row[1] ?? null;
                    
                    if (!$dateValue) {
                        throw new \Exception("Date value is missing for row " . ($key + 1));
                    }
                    
                    // Debug: Show the date value
                    if ($key === 0) {
                        $this->info("Sample date value from Excel: '{$dateValue}' (type: " . gettype($dateValue) . ")");
                    }
                    
                    // Excel stores dates as numeric values (days since 1900-01-01)
                    if (is_numeric($dateValue)) {
                        try {
                            $dateTime = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateValue);
                            $submissionDate = Carbon::instance($dateTime);
                            
                            // Validate the year is reasonable (between 1900 and 2100)
                            if ($submissionDate->year < 1900 || $submissionDate->year > 2100) {
                                throw new \Exception("Invalid date year: {$submissionDate->year} for value: {$dateValue}");
                            }
                        } catch (\Exception $e) {
                            throw new \Exception("Failed to parse Excel date '{$dateValue}' for row " . ($key + 1) . ": " . $e->getMessage());
                        }
                    } else {
                        $submissionDate = Carbon::parse($dateValue);
                    }
                    
                    $submissionDate->setTime(8, 0, 0);

                    $form_submited = FormSubmissions::create([
                        'submission_id' => Str::uuid(),
                        'form_id' => 5,
                        'user_id' => $users->user_id,
                        'vehicle_id' => $vehicles->id,
                        'submitted_by' => $users->user_id,
                        'status' => 1,
                        'org' => $orgId,
                        'created_at' => $submissionDate,
                        'updated_at' => $submissionDate,
                    ]);

                    foreach ($this->formfields as $key => $value) {
                        FormSubmissionValue::create([
                            'submission_id' => $form_submited->id,
                            'field_id' => $key,
                            'value' => $row[$value],
                            'submitted_by' => $users->user_id,
                        ]);
                    }
                    $successCount++;
                }
            }

            DB::commit();
            $this->info("Import completed successfully!");
            $this->info("Total processed: {$successCount}");
            $this->info("Total skipped: {$skipCount}");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Import failed! Rolling back all changes...");
            $this->error("Error: " . $e->getMessage());
            $this->error("File: " . $e->getFile());
            $this->error("Line: " . $e->getLine());
        }
    }

    /**
     * Read and parse Excel file
     */
    private function readExcelFile()
    {
        $filePath = public_path('imports/493_Pimthong_Logistics.xlsx');
        
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return [];
        }

        $this->info("Reading file: {$filePath}");

        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Remove empty rows
            $rows = array_filter($rows, function($row) {
                return !empty(array_filter($row));
            });

            // Reset array keys
            $rows = array_values($rows);

            // Remove header rows (first two rows)
            if (!empty($rows)) {
                array_shift($rows);
                array_shift($rows);
            }

            $this->info("Found " . count($rows) . " rows in the Excel file");

            return $rows;

        } catch (\Exception $e) {
            $this->error("Error reading Excel file: " . $e->getMessage());
            return [];
        }
    }
}
