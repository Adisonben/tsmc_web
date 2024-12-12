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
use Illuminate\Console\Command;

class ClearPreview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-preview';

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
        try {
            echo 'find user.....' . "\n";
            $user = User::where('username', 'tsmcpreview')->firstOrFail();

            try {
                echo 'Delete Post.......' . "\n";
                Post::where('created_by', $user->id)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Post failed!!' . "\n";
            }

            try {
                echo 'Delete Post_comment.......' . "\n";
                Post_comment::where('user_id', $user->id)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Post_comment failed!!' . "\n";
            }

            try {
                echo 'Delete Post_media.......' . "\n";
                Post_media::where('created_by', $user->id)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Post_media failed!!' . "\n";
            }

            try {
                echo 'Delete Form_response.......' . "\n";
                Form_response::where('user_id', $user->id)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Form_response failed!!' . "\n";
            }

            try {
                echo 'Delete Form_answer.......' . "\n";
                Form_answer::where('user_id', $user->id)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Form_answer failed!!' . "\n";
            }

            try {
                echo 'Delete Form.......' . "\n";
                Form::where('created_by', $user->id)->delete();
            } catch (\Throwable $th) {
                echo 'Delete Form failed!!' . "\n";
            }

            try {
                echo 'Delete FormPlan.......' . "\n";
                FormPlan::where('user_id', $user->id)->delete();
            } catch (\Throwable $th) {
                echo 'Delete FormPlan failed!!' . "\n";
            }
        } catch (\Throwable $th) {
            echo 'user not found!!' . "\n";
        }
    }
}
