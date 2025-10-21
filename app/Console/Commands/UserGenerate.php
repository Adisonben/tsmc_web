<?php

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Organization;
use App\Models\User;
use App\Models\User_detail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-generate {number=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $number = $this->argument('number');
        if ($number == 0) {
            $number = $this->ask('How many users do you want to generate? (0-99)');
        }
        if ($number >= 100) {
            $this->error('The number of users to generate must be less than 100.');
            return;
        }
        $orgCount = Organization::where('name', 'LIKE', '%สถาบันฝึกอบรม เทรนนิ่งเซ็นเตอร์%')->count();
        $userCount = User::where('username', 'LIKE', 'tsmc0%')->count();

        for ($i=0; $i < $number; $i++) {
            $orgNumber = $i + 1 + $orgCount;
            $userNumber = $i + 1 + $userCount;
            try {
                echo "Creating new organization...\n";
                $newOrg = Organization::create([
                    'org_id' => Str::uuid(),
                    'name' => "สถาบันฝึกอบรม เทรนนิ่งเซ็นเตอร์ (" . $orgNumber . ")",
                ]);

                $newBrn = Branch::create([
                    'brn_id' => Str::uuid(),
                    'name'=> "TrainingZenter",
                    'org_id' => $newOrg->id,
                ]);

                $newDpm = Department::create([
                    'dpm_id' => Str::uuid(),
                    'name'=> "TrainingZenter",
                    'brn_id' => $newBrn->id,
                ]);

                echo "Create new org " . $orgNumber . " success...\n";
            } catch (\Throwable $th) {
                //throw $th;
                echo "Failed to create new organization...\n";
                $newOrg?->delete();
                $newBrn?->delete();
                $newDpm?->delete();
                break;
            }

            try {
                // Create the user
                $newUser = User::create([
                    'user_id' => Str::uuid(),
                    'username' => "tsmc0" . $userNumber,
                    'password' => Hash::make("12345678"),
                    'pass_text' => "12345678",
                ]);

                User_detail::create([
                    'user_id' => $newUser->id,
                    'prefix' => 1,
                    'fname' => "TSMC",
                    'lname' => "0" . $userNumber,
                    'org' => $newOrg->id,
                    'brn' => $newBrn->id,
                    'dpm' => $newDpm->id,
                    'position' => 1,
                ]);
                echo "Create new user tsmc0" . $userNumber . " success...\n";
            } catch (\Throwable $th) {
                //throw $th;
                echo "Failed to create new user...\n";
                $newOrg?->delete();
                $newBrn?->delete();
                $newDpm?->delete();
                $newUser?->delete();
                break;
            }
        }
    }
}
