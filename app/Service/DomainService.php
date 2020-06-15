<?php
declare(strict_types=1);

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use App\Models\Domain;

use Log;

class DomainService
{
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    public function storeDomain(string $url)
    {
        if (empty($this->domain->getByName(Domain::extractDomainName($url)))) {
            $this->domain->fill(['name' => $url])->save();
        }
    }
  }
