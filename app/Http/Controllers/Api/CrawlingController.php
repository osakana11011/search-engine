<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Crawling;
use Illuminate\Http\Request;
use App\Service\CrawlingService;
use Log;
use Auth;

class CrawlingController extends Controller
{
    private $crawlingService;

    public function __construct(CrawlingService $crawlingService)
    {
        $this->crawlingService = $crawlingService;
    }

    public function index()
    {
        return response()->json([
            Crawling::orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function create(Request $request)
    {
        Log::info($request->input('url'));

        Crawling::create([
            'url' => $request->input('url'),
        ]);
        return response('OK', 200);
        // $this->crawlingService->createWithUserID($request->attributes());
        // ProcessCrawling::dispatch($request->input('url'));
    }
}
