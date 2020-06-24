<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Log;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログインのテスト(成功時)
     * - ステータスコード200が返ってくるか
     * - jsonの構成は正しいか
     * - Cookieとしてtokenが返ってきているか
     */
    public function testLogin()
    {
        $user = factory(User::class)->create()->first();
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Success',
            ])
            ->assertCookie('token');
    }

    /**
     * ログインのテスト(失敗時)
     * - ステータスコード401が返ってくるか
     * - jsonの構成は正しいか
     * - Cookieとしてtokenが返ってきていないか
     */
    public function testLoginFailed()
    {
        $user = factory(User::class)->create()->first();
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
            'password' => 'invalid_password',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthorized',
            ])
            ->assertCookieMissing('token');
    }

    /**
     * ログインのテスト(バリデーションエラー)
     * - ステータスコードは422が返ってきているか
     * - 期待した構造のjsonが返ってきているか
     * - Cookieとしてtokenが返ってきていないか
     */
    public function testLoginValidationError1()
    {
        $user = factory(User::class)->create()->first();
        $response = $this->post('/api/auth/login', [
            'email' => $user->email,
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'summary' => 'Failed validation.',
                'errors' => [
                    'password' => [
                        'The password field is required.',
                    ],
                ]
            ])
            ->assertCookieMissing('token');
    }

    /**
     * ログインのテスト(バリデーションエラー)
     * - ステータスコードは422が返ってきているか
     * - 期待した構造のjsonが返ってきているか
     * - Cookieとしてtokenが返ってきていないか
     */
    public function testLoginValidationError2()
    {
        $user = factory(User::class)->create()->first();
        $response = $this->post('/api/auth/login', [
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'summary' => 'Failed validation.',
                'errors' => [
                    'email' => [
                        'The email field is required.',
                    ],
                    'password' => [
                        'The password field is required.',
                    ],
                ]
            ])
            ->assertCookieMissing('token');
    }
}
