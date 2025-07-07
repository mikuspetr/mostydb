<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Record;
use App\Models\IndividualPlan;

class CleanRecordText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:text {--model=record : The model to clean (record or individual-plan)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove HTML tags from the text column in the records or individual_plans table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelType = $this->option('model');
        
        // Determine which model to use
        $modelClass = match ($modelType) {
            'individual-plan' => IndividualPlan::class,
            'record' => Record::class,
            default => Record::class,
        };
        
        $modelName = match ($modelType) {
            'individual-plan' => 'individual plans',
            'record' => 'records',
            default => 'records',
        };

        $count = 0;
        $modelClass::chunk(100, function ($items) use (&$count) {
            foreach ($items as $item) {
                $cleaned = strip_tags($item->text);
                if ($item->text !== $cleaned) {
                    $item->text = $cleaned;
                    $item->save();
                    $count++;
                }
            }
        });

        $this->info("Cleaned HTML tags from $count $modelName.");
    }
}
