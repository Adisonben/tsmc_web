<?php

namespace App\Console\Commands;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Console\Command;

class SetUnexpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-unexpire {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a user\'s account to never expire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Validate the input
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

        if ($user->is_tsm) {
            // Set the user's account to never expire
            $user->expire_at = null; // Assuming expires_at is the field for expiration
            $user->save();
        } else {
            $org = Organization::where('id', $user->userDetail?->org)->first();
            if ($org) {
                // Set the organization's users to never expire
                $org->update(['expire_at' => null]); // Assuming expires_at is the field for expiration
            } else {
                $this->error('Organization not found for the user.');
                return 1; // Return a non-zero status code to indicate failure
            }
        }

        $this->info("User '$username' account set to never expire.");
        return 0; // Return 0 to indicate success
    }
}
