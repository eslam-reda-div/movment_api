<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dbexport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the database to a SQL file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('pulse_aggregates')->truncate();
        DB::table('pulse_entries')->truncate();
        DB::table('pulse_values')->truncate();

        DB::table('cache')->truncate();
        DB::table('cache_locks')->truncate();

        DB::table('activity_log')->truncate();
        DB::table('health_check_result_history_items')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Set the backup file name and path
        $filename = database_path('backups').'/'.env('DB_EXPORT_FILE_NAME').'_'.now()->format('Y_m_d_H_i_s').'.sql';

        // Ensure the backups directory exists
        if (! is_dir(database_path('backups'))) {
            mkdir(database_path('backups'));
        }

        // Create a temporary config file for mysqldump credentials
        $configFile = tempnam(sys_get_temp_dir(), 'mycnf');
        file_put_contents($configFile, sprintf(
            "[client]\nuser=%s\npassword=%s\nhost=%s\n",
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_HOST')
        ));

        // Modify the mysqldump command to disable column statistics
        $command = sprintf(
            'mysqldump --defaults-extra-file=%s --column-statistics=0 %s --add-drop-database --add-drop-table --complete-insert --extended-insert --lock-tables -f > %s',
            escapeshellarg($configFile),
            escapeshellarg(env('DB_DATABASE')),
            escapeshellarg($filename)
        );

        // Execute the command
        exec($command, $output, $return_var);
        unlink($configFile); // Remove temporary config file

        // Check if the export was successful
        if ($return_var === 0) {
            $this->info('Database exported successfully to '.$filename);
        } else {
            $this->error('Database export failed. Error: '.implode(PHP_EOL, $output));
        }
    }
}
