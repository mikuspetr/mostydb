<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Record;

class CleanRecordText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'records:clean-text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove HTML tags from the text column in the records table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = 0;
        Record::chunk(100, function ($records) use (&$count) {
            foreach ($records as $record) {
                $cleaned = strip_tags($record->text);
                if ($record->text !== $cleaned) {
                    $record->text = $cleaned;
                    $record->save();
                    $count++;
                }
            }
        });

        $this->info("Cleaned HTML tags from $count records.");
    }
}
