<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Crawling;
use Illuminate\Http\Request;
use App\Service\CrawlingService;
use App\Jobs\CrawlingJob;
use Log;
use Auth;

class CrawlingController extends Controller
{
    private $user;
    private $crawlingService;

    public function __construct(CrawlingService $crawlingService)
    {
        $this->user = auth()->user();
        $this->crawlingService = $crawlingService;
    }

    public function index()
    {
        $crawlings = $this->crawlingService->getByUserID($this->user->id);
        return response()->json([
            $crawlings,
        ]);
    }

    public function create(Request $request)
    {
        Crawling::create([
            'user_id' => $this->user->id,
            'url' => $request->input('url'),
        ]);
        CrawlingJob::dispatch($request->input('url'));
        return response('OK', 200);
    }
}
