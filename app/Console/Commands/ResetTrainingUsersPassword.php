<?php

namespace App\Console\Commands;

use App\Models\Form;
use App\Models\Form_answer;
use App\Models\Form_response;
use App\Models\FormPlan;
use App\Models\Post;
use App\Models\Post_comment;
use App\Models\Post_media;
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
                    echo "\n Updated user : " . $user->username . " password success.\n";

                    $this->clearData($user->id);
                    echo "\n Clear data success.\n";
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

    public function clearData ($userId) {
        if ($userId) {
            try {
                echo 'Delete Post.......' . "\n";
                Post::where('created_by', $userId)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Post failed!!' . "\n";
            }

            try {
                echo 'Delete Post_comment.......' . "\n";
                Post_comment::where('user_id', $userId)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Post_comment failed!!' . "\n";
            }

            try {
                echo 'Delete Post_media.......' . "\n";
                $post_medias = Post_media::where('created_by', $userId)->get();
                foreach ($post_medias as $media) {
                    $filePath = public_path($media->folder . '/' . $media->file_name);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        $media->delete();
                    }
                }
            } catch (\Throwable $th) {
                echo 'Delete Post_media failed!!' . "\n";
            }

            try {
                echo 'Delete Form_response.......' . "\n";
                Form_response::where('user_id', $userId)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Form_response failed!!' . "\n";
            }

            try {
                echo 'Delete Form_answer.......' . "\n";
                Form_answer::where('user_id', $userId)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Form_answer failed!!' . "\n";
            }

            try {
                echo 'Delete Form.......' . "\n";
                Form::where('created_by', $userId)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Form failed!!' . "\n";
            }

            try {
                echo 'Delete FormPlan.......' . "\n";
                FormPlan::where('user_id', $userId)->delete();
            } catch (\Throwable $th) {
                echo 'Delete FormPlan failed!!' . "\n";
            }
        } else {
            echo 'User id not found!!' . "\n";
        }
    }
}
