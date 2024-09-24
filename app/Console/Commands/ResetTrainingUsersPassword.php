<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetTrainingUsersPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:resetUsersPassword';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'set users password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            echo "------------ Starting update user password ---------------";
            $users = User::where('username', 'LIKE', "%tsmc0%")->get();
            $nowDate = Carbon::now()->locale('th');
            $mondayDate = $nowDate->startOfWeek(Carbon::MONDAY)->format("dmY");
            $passwordToupdate = "tsmc" . $mondayDate;
            echo "\n Users count : " . count($users ?? []) . ", Date : " . $mondayDate;
            echo "\n Password to set : " . $passwordToupdate ?? '-';
            foreach ($users as $user) {
                try {
                    $user->update([
                        'password' => Hash::make($passwordToupdate),
                        'pass_text' => $passwordToupdate ?? null,
                    ]);
                    echo "\n Updated user : " . $user->username . " password success.";
                } catch (\Throwable $th) {
                    //throw $th;
                    echo "\n !!! Error for update user : " . $user->username . " !!!";
                }
            }
            echo "\n ------------ Update user password Success. ---------------";
        } catch (\Throwable $th) {
            //throw $th;
            echo "\n !!!!! Error to update users password !!!!!\n";
        }
    }
}
