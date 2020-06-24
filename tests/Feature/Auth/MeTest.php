<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use JWTAuth;
use WithoutMiddleware;
use Log;

class MeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 検証内容: 成功時のログイン者情報を取得する。
     */
    public function testMeSuccess()
    {
        $this->disableCookiesEncryption(['token']);
        $user = factory(User::class)->create()->first();
        $token = JWTAuth::fromUser($user);
        $response = $this->call('POST', 'api/auth/me', [], ['token' => $token]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'email_verified_at',
                'created_at',
                'updated_at',
            ])->assertJsonMissing([
                'password',
                'remember_token',
            ]);
    }

    /**
     * 検証内容: JWTトークンが間違っている時の挙動
     */
    public function testMeFailed()
    {
        $this->disableCookiesEncryption(['token']);
        $user = factory(User::class)->create()->first();
        $token = JWTAuth::fromUser($user);
        $invalidToken = $token.'hogehoge';
        $response = $this->json('POST', 'api/auth/me', [], ['token' => $invalidToken], [], ['HTTP_ACCEPT' => 'application/json']);

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
