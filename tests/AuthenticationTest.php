<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticationTest extends WebTestCase
{
    private static ?KernelBrowser $client = null;
    protected function setUp()
    {
        self::$client = static::createClient();
    }

    public function testLoginUrlSuccessfully()
    {

        self::$client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"username":"admin@admin.com","password":"admin123456"}'
        );
        $this->assertEquals(200, self::$client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('token', json_decode(self::$client->getResponse()->getContent(), true));
    }

    public function testLoginUrlInvalidCredential()
    {
        self::$client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"username":"","password":""}'
        );
        $this->assertEquals(401, self::$client->getResponse()->getStatusCode());
    }


}
