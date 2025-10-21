<?php

namespace App\Console\Commands;

use App\Models\Organization;
use Illuminate\Console\Command;

class SetDefaultOrgData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-default-org {id} {unset?}'; // Command signature with required 'id' and optional 'unset' arguments

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description'; // Description of the command

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve the 'id' argument and the optional 'unset' argument
        $id = $this->argument('id');
        $unset = $this->argument('unset') ? true : false;

        // Find the current default organization with the given ID and status 2 (default)
        $oldDefaultOrg = Organization::where('id', $id)->where('status', 2)->first() ?? null;

        if ($unset) { // If the 'unset' argument is provided
            if ($oldDefaultOrg) {
                // Change the status of the current default organization to 1 (non-default)
                $oldDefaultOrg->status = 1;
                $oldDefaultOrg->save();
            }
            // Output the ID of the organization that was unset
            echo "Unset default org ID: $oldDefaultOrg?->id\n";
        } else { // If the 'unset' argument is not provided
            if (Organization::where('id', $id)->exists()) { // Check if the organization with the given ID exists
                // Find the organization and set its status to 2 (default)
                $org = Organization::find($id);
                $org->status = 2;
                $org->save();

                if ($oldDefaultOrg) {
                    // Change the status of the previous default organization to 1 (non-default)
                    $oldDefaultOrg->status = 1;
                    $oldDefaultOrg->save();
                }

                // Output the change from the old default organization to the new one
                echo "Set from {$oldDefaultOrg?->id} to {$org->id}\n";
            } else {
                // Output an error message if the organization is not found
                $this->error('Organization not found.');
                return 1; // Return a non-zero status code to indicate failure
            }
        }
    }
}
