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
        Log::info('START - Crawling Job.');

        // 1. ドメイン情報の登録
        $domain = Domain::firstOrCreate(['name' => Domain::extractDomainName($this->crawlingURL)]);

        // 2. robots.txtをスクレイピング
        $robotsURL = "https://{$domain->name}/robots.txt";
        exec("node ./resources/js/scraping/robots.js --url {$robotsURL}", $_robotsResult);
        $robotsResult = json_decode($_robotsResult[0]);

        // 3. ページをスクレイピング
        exec("node ./resources/js/scraping/page.js --url {$this->crawlingURL}", $_pageResult);
        $pageResult = json_decode($_pageResult[0]);
        Log::info(print_r($pageResult, true));

        // exec("node ./resources/js/scraping/index.js --url {$this->crawlingURL}", $result);
        // Log::debug(print_r(json_decode($result[0]), true));
        // $result = json_decode($result[0]);
        // Log::info("title: {$result->title}");
        Log::info('END   - Crawling Job.');
    }
}
