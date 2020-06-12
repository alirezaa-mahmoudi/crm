<?php

namespace App\Tests\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticationTest extends WebTestCase
{

    public function testLoginUrlSuccessfully()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"username":"admin@admin.com","password":"admin123456"}'
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('token', json_decode($client->getResponse()->getContent(), true));
    }

    public function testLoginUrlInvalidCredential()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"username":"","password":""}'
        );
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }


}
