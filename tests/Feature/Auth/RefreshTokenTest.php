<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use JWTAuth;
use WithoutMiddleware;
use Log;

class RefreshTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 検証内容: トークンのリフレッシュ処理が成功する時の挙動
     */
    public function testRefreshTokenSuccess()
    {
        $this->disableCookiesEncryption(['token']);
        $user = factory(User::class)->create()->first();
        $token = JWTAuth::fromUser($user);
        $response = $this->call('POST', 'api/auth/refresh', [], ['token' => $token]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Success',
            ]);
    }

    /**
     * 検証内容: JWTトークンが間違っていてリフレッシュ処理が成功しない時の挙動
     */
    public function testRefreshTokenFailed()
    {
        $this->disableCookiesEncryption(['token']);
        $user = factory(User::class)->create()->first();
        $token = JWTAuth::fromUser($user);
        $invalidToken = $token.'hogehoge';
        $response = $this->json('POST', 'api/auth/refresh', [], ['token' => $invalidToken], [], ['HTTP_ACCEPT' => 'application/json']);

        $response
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * Cookieの暗号化をオフにする。
     * @param $name
     * @return $this
     */
    protected function disableCookiesEncryption($name)
    {
        $this->app->resolving(EncryptCookies::class, function ($object) use ($name) {
            $object->disableFor($name);
        });

        return $this;
    }
}
