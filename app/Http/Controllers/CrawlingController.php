<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CrawlingRequest;
use App\Jobs\ProcessCrawling;
use App\Models\Crawling;
use App\Service\CrawlingService;

class CrawlingController extends Controller
{
    private $crawlingService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CrawlingService $crawlingService)
    {
        $this->middleware('auth');
        $this->crawlingService = $crawlingService;
    }

    public function index()
    {
        $crawlings = Crawling::all();
        return view('crawling.index', compact('crawlings'));
    }

    public function create(CrawlingRequest $request)
    {
        $this->crawlingService->createWithUserID($request->attributes());
        ProcessCrawling::dispatch($request->input('url'));
        return redirect('/crawling');
    }

    public function crawlings()
    {
        return response()->json([
            'hoge' => 'hoge',
        ]);
    }
}
