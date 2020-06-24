<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class Domain extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'deleted_at',
    ];

    /**
     * URLからドメイン名を抜き出す。
     * @param string $url
     * @return string
     */
    static public function extractDomainName (string $url)
    {
        // この後の正規表現の為に、最後の1文字が'/'で終わらないURLの場合は付けておく。
        $_url = (mb_substr($url, -1) !== '/') ? $url.'/' : $url;

        return preg_match('/^https?:\/\/(.*?)[:\d]*\//', $_url, $result) ? $result[1] : $url;
    }
}
