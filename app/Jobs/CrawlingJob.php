<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Log;

class CrawlingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $crawlingURL;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $crawlingURL)
    {
        $this->crawlingURL = $crawlingURL;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // var_dump($this->crawlingURL);
        Log::info('START - Crawling Job.');
        Log::info($this->crawlingURL);
        Log::info('END   - Crawling Job.');
    }
}
