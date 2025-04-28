<?php

namespace App\Console\Commands;

use App\Models\Position_permission;
use Illuminate\Console\Command;

class AddPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-permission {name} {label}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new permission to the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Validate the input
        $name = $this->argument('name');
        $label = $this->argument('label');

        if (empty($name) || empty($label)) {
            $this->error('Both name and label are required.');
            return 1; // Return a non-zero status code to indicate failure
        }
        // Check if the permission already exists
        $existingPermission = Position_permission::where('perm_name', $name)->first();
        if ($existingPermission) {
            $this->error('Permission already exists.');
            return 1; // Return a non-zero status code to indicate failure
        }
        // Create the new permission
        Position_permission::create([
            'perm_name' => $name,
            'label' => $label,
        ]);
        echo "Creating permission: $name with label: $label\n";
        $this->info('Permission added successfully.');
        return 0; // Return 0 to indicate success
    }
}
