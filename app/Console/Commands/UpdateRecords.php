<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update records with specific criteria';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $records = \App\Models\Record::where('date', '>=', '2026-01-01')
            ->whereIn('form_id', [2,3])
            ->update([
                'duration_pp' => 0,
            ]); 
        dump('Records updated: ' . $records);
    }
}
