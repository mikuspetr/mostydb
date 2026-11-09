<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-contacts';

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
        $records = \App\Models\Record::where('date', '>', '2026-01-01')->contacts()
            ->update([
                // Specify the fields to update here, for example:
                // 'contacted' => true
                'duration_pp' => 0,
            ]); 
                dump('OK');
    }
}
