<?php
declare(strict_types=1);

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Models\Crawling;

class CrawlingService
{
    public function createWithUserID(array $data)
    {
        $data['user_id'] = Auth::id();
        Crawling::create($data);
    }
  }
