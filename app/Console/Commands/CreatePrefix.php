<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class CreatePrefix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-prefix {mode : add|remove} {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or remove prefixes. Usage: app:create-prefix add|remove name. Use % in name for SQL LIKE patterns.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mode = strtolower($this->argument('mode'));
        $name = $this->argument('name');

        if (empty($mode) || !in_array($mode, ['add', 'remove'])) {
            $this->error("Invalid mode. Use 'add' or 'remove'.");
            return 1;
        }

        if (empty($name)) {
            $this->error('The name argument is required.');
            return 1;
        }

        try {
            if ($mode === 'add') {
                $exists = DB::table('prefixes')->where('name', $name)->exists();
                if ($exists) {
                    $this->error("Prefix '{$name}' already exists.");
                    return 1;
                }

                DB::table('prefixes')->insert([
                    'name' => $name,
                    'created_by' => 0
                ]);

                $this->info("Prefix '{$name}' created successfully.");
                return 0;
            }

            // remove mode
            if (strpos($name, '%') !== false) {
                // treat provided name as SQL LIKE pattern
                $query = DB::table('prefixes')->where('name', 'like', $name);
                $matchDesc = "pattern match '{$name}'.";
            } else {
                $query = DB::table('prefixes')->where('name', $name);
                $matchDesc = "exact match '{$name}'.";
            }

            $count = $query->count();
            if ($count === 0) {
                $this->error("No prefixes found for {$matchDesc}");
                return 1;
            }

            $confirm = true;
            if ($count > 1) {
                $confirm = $this->confirm("Found {$count} prefixes for {$matchDesc} Delete all?", false);
            } else {
                $confirm = $this->confirm("Delete the prefix matching {$matchDesc}?", false);
            }

            if (! $confirm) {
                $this->info('Aborted. No changes made.');
                return 0;
            }

            $deleted = $query->delete();
            $this->info("Deleted {$deleted} prefix(es).");
            return 0;
        } catch (Exception $e) {
            $this->error('Operation failed: ' . $e->getMessage());
            return 1;
        }
    }
}
