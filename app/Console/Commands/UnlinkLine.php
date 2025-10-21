<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UnlinkLine extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:unlink-line {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'unline user from LINE';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $username = $this->argument('username');

        if (empty($username)) {
            $this->error('Username is required.');
            return 1; // Return a non-zero status code to indicate failure
        }

        // Find the user by username
        $user = User::where('username', $username)->first();

        if (!$user) {
            $this->error('User not found.');
            return 1; // Return a non-zero status code to indicate failure
        }

        $user->line_user_id = null; // Unlink LINE user ID
        $user->save();
        $this->info('User unlinked from LINE successfully.');
    }
}
