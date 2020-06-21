<?php
declare(strict_types=1);

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;
use App\Models\Crawling;
use Log;

class CrawlingTest extends TestCase
{
    use RefreshDatabase;

    private $crawling;

    public function setUp(): void
    {
        parent::setUp();
        $this->crawling = new Crawling();
    }

    /**
     * 検証内容: 10ユーザーがそれぞれ5個ずつクローリング情報を登録している時、getByUserIDでユーザーが登録したクローリング情報のみ引っ張ってこれるか。
     */
    public function testGetByUserID1()
    {
        $user = factory(User::class, 10)
            ->create()
            ->each(function ($user) {
                $user->crawlings()->createMany(factory(Crawling::class, 5)->make()->toArray());
            })
            ->first();

        $actual = $this->crawling->getByUserID($user->id);
        $this->assertCount(5, $actual);
    }

    /**
     * 検証内容: 存在しないユーザーIDを与えた時、エラーが出ずに空配列が返ってくるか。
     */
    public function testGetByUserID2()
    {
      $user = factory(User::class, 5)
          ->create()
          ->each(function ($user) {
              $user->crawlings()->createMany(factory(Crawling::class, 5)->make()->toArray());
          })
          ->first();

      $actual = $this->crawling->getByUserID(10);
      $this->assertCount(0, $actual);
    }

    /**
     * 検証内容: 引数として文字列型を与えた時、エラーが出るか。
     */
    public function testGetByUserID3()
    {
        $user = factory(User::class, 3)
            ->create()
            ->each(function ($user) {
                $user->crawlings()->createMany(factory(Crawling::class, 5)->make()->toArray());
            })
            ->first();

        $this->expectException(\TypeError::class);
        $actual = $this->crawling->getByUserID('test');
    }

    /**
     * 検証内容: 自分の登録したデータが多い時、指定した件数を正常に取れてこれるか。
     */
    public function testGetByUserID4()
    {
        $user = factory(User::class, 5)
            ->create()
            ->each(function ($user) {
                $user->crawlings()->createMany(factory(Crawling::class, 50)->make()->toArray());
            })
            ->first();

        $actual = $this->crawling->getByUserID($user->id);
        $this->assertCount(10, $actual);
    }

    /**
     * 検証内容: 自分の登録したデータが多い時、指定した件数を正常に取れてこれるか。
     */
    public function testGetByUserID5()
    {
        $user = factory(User::class, 5)
            ->create()
            ->each(function ($user) {
                $user->crawlings()->createMany(factory(Crawling::class, 50)->make()->toArray());
            })
            ->first();

        $actual = $this->crawling->getByUserID($user->id, 30);
        $this->assertCount(30, $actual);
    }
}
