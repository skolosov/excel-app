<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExcelTest extends TestCase
{
    use DatabaseTransactions;

    public function getToken()
    {
        $response = $this
            ->post(
                'api/auth/login',
                ['email' => 'kolos@test.ru', 'password' => '12345678'],
                ['Accept' => 'application/json']
            );
        return json_decode($response->getContent())->access_token;
    }
}
