<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\select;

class ProjectSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with the exported data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $backupPath = database_path('backups');

        if (! is_dir($backupPath)) {
            $this->error('Backup directory does not exist.');

            return;
        }

        $files = File::files($backupPath);

        $backupFiles = array_map(function ($file) {
            return $file->getFilename();
        }, $files);

        $dumper = select(
            label: 'Choose the database buckup file to seed it.',
            options: $backupFiles,
            default: end($backupFiles),
        );

        if (! $this->confirm('This will delete all existing tables. Are you sure you want to continue?')) {
            $this->info('Operation cancelled.');

            return;
        }

        try {
            $sqlPath = $backupPath.'/'.$dumper;
            if (! File::exists($sqlPath)) {
                $this->error('Selected backup file does not exist.');

                return;
            }

            $tables = DB::select('SHOW TABLES');

            if (empty($tables)) {
                $this->info('No tables found in the database.');
            } else {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');

                foreach ($tables as $table) {
                    $tableName = reset($table);
                    DB::statement('DROP TABLE IF EXISTS '.$tableName);
                }

                DB::statement('SET FOREIGN_KEY_CHECKS=1');
                $this->info('All tables dropped successfully.');
            }

            $sqlContent = File::get($sqlPath);
            DB::unprepared($sqlContent);

            $this->info('Database seeded successfully!');
        } catch (\Exception $e) {
            $this->error('An error occurred: '.$e->getMessage());

            return 1;
        }
    }
}
