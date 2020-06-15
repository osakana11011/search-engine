<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'deleted_at',
    ];


    public function setNameAttribute (string $url)
    {
        $this->attributes['name'] = self::extractDomainName($url);
    }


    static public function extractDomainName (string $url)
    {
        // この後の正規表現の為に、最後の1文字が'/'で終わらないURLの場合は付けておく。
        if (mb_substr($url, -1) !== '/') {
            $url .= '/';
        }

        return preg_match('/^http[s]?:\/\/(.*?)\//', $url, $result) ? $result[1] : $url;
    }


    public function getByName (string $name)
    {
        return $this->where('name', $name)->first();
    }
}
