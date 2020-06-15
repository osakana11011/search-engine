<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Domain;

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

        // ドメイン情報の登録
        $domain = Domain::firstOrCreate(['name' => Domain::extractDomainName($this->crawlingURL)]);

        // exec("node ./resources/js/scraping/index.js --url {$this->crawlingURL}", $result);
        // Log::debug(print_r(json_decode($result[0]), true));
        // $result = json_decode($result[0]);
        // Log::info("title: {$result->title}");
        Log::info('END   - Crawling Job.');
    }
}
