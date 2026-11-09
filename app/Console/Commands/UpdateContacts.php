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
        
        $records = \App\Models\Record::contacts()
            ->whereIn('form_id', [2,3])
            ->update([
                'duration_pp' => 0,
            ]); 
        dump('Records updated: ' . $records);
    }
}
