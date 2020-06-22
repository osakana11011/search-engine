<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use JWTAuth;
use WithoutMiddleware;
use Log;

class LoginTest extends TestCase
{
    use RefreshDatabase;

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
     * @param $name
     * @return $this
     */
    protected function disableCookiesEncryption($name)
    {
        $this->app->resolving(EncryptCookies::class,
            function ($object) use ($name)
            {
                $object->disableFor($name);
            });

        return $this;
    }
}
