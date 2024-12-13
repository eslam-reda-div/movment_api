<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProjectInitialize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Project Initialization';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running migrations...');
        $this->call('migrate', [
            '--force' => true,  // Ensure migrations run without confirmation
            '--no-interaction' => true,  // Skip all prompts
        ]);

        // Generate shield permissions for the 'admin' panel without interaction
        $this->info('Generating shield permissions for admin panel...');
        $this->call('shield:generate', [
            '--panel' => 'admin',  // Automatically choose the 'admin' panel
            '--all' => true,        // Generate for all entities
            '--no-interaction' => true,  // Skip interaction
        ]);

        // Clear cache and optimize
        $this->info('Clearing cache and optimizing...');
        $this->call('optimize:clear', [
            '--no-interaction' => true,  // Skip interaction
        ]);

        $this->info('Project update completed.');
    }
}
