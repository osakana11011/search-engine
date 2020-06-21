<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Crawling extends Model
{
    const BEFORE_CRAWLING = 0;
    const UNDER_CRAWLING = 1;
    const AFTER_CRAWLING = 2;
    const CANCELED = 3;

    protected $guarded = [
        'id',
        'created_at',
        'deleted_at',
    ];

    /**
     * ユーザーIDを元にCrawlingを取得する。
     * @param int $userID
     * @param int $n
     * @return Collection
     */
    public function getByUserID(int $userID, int $n = 10)
    {
        return $this->where('user_id', $userID)
            ->orderBy('created_at', 'desc')
            ->paginate($n);
    }

    /**
     * ログイン中のユーザーIDを付け加えて登録する。
     * @param array $data
     * @return Crawling
     */
    public function createWithUserID(User $user)
    {
        $this->fill([
            'user_id' => $user->id,
        ])->save();
    }
}
