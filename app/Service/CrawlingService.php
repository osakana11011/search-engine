<?php
declare(strict_types=1);

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Models\Crawling;

class CrawlingService
{
    public function __construct(Crawling $crawling)
    {
        $this->crawling = $crawling;
    }

    public function getByUserID(int $userID)
    {
        return $this->crawling
            ->filterByUserID($userID)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function createWithUserID(array $data)
    {
        $data['user_id'] = Auth::id();
        Crawling::create($data);
    }
  }
