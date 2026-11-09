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
        /*
        $records = \App\Models\Record::where('date', '>', '2026-01-01')->contacts()
            ->update([
                // Specify the fields to update here, for example:
                // 'contacted' => true
                'duration_pp' => 0,
            ]); 
                dump('OK');
        */
        $updates = [
            [5698, 1],
            [5699, 1],
            [5739, 1],
            [5741, 1],
            [5743, 1],
            [5751, 1],
            [5781, 1],
            [5808, 1],
            [5819, 5],
            [5820, 8],
            [5821, 8],
            [5833, 10],
            [5866, 1],
            [5917, 1],
            [6054, 1]
        ];
        foreach ($updates as $update) {
            $recordId = $update[0];
            $durationPP = $update[1];
            \App\Models\Record::where('id', $recordId)->update(['duration_pp' => $durationPP]);
        }
        dump('Updates completed');
    }
}
