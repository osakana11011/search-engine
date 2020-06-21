<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\CrawlingRequest;
use App\Http\Controllers\Controller;
use App\Models\Crawling;
use App\Jobs\CrawlingJob;
use Log;
use Auth;

class CrawlingController extends Controller
{
    private $user;
    private $crawling;

    public function __construct(Crawling $crawling)
    {
        $this->user = auth()->user();
        $this->crawling = $crawling;
    }

    public function index()
    {
        $crawlings = $this->crawling->getByUserID($this->user->id);
        return response()->json([
            $crawlings,
        ]);
    }

    public function create(CrawlingRequest $request)
    {
        $crawlingUrl = 'https://'.$request->input('url');
        $this->crawling->fill([
            'user_id' => $this->user->id,
            'url' => $crawlingUrl,
        ])->save();
        CrawlingJob::dispatch($crawlingUrl);

        return response('OK', 200);
    }
}
