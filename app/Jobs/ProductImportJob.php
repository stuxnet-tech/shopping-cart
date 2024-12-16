<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProductImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $importData;
    public $modulePath;

    public function __construct($importData, $modulePath)
    {
        $this->importData = $importData;
        $this->modulePath = $modulePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $modelClass = $this->modulePath;

        $insertData = $this->importData;

        $modelClass::insert($insertData);
        
    }
}
