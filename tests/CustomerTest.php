<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerTest extends WebTestCase
{
    public function login()
    {
        $client = self::createClient();

        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"username":"admin@admin.com", "password":"admin123456"}'
        );

        return $client;
    }

    public function testCustomersAuthorization()
    {
        $client = $this->login();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);
    }

    public function testUnauthorizedAccessCustomer()
    {
        $client = self::createClient();
        $client->request('GET', '/api/customers');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testCustomersUrl()
    {
        $client = $this->login();
        $token = json_decode($client->getResponse()->getContent())->token;
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));
        $client->setServerParameter('CONTENT_TYPE', 'application/json');
        $client->setServerParameter('HTTP_ACCEPT', 'application/json');
        $client->request(
            'GET',
            '/api/customers',
        );
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals('dsds', $response->getContent());
    }
    public function testCustomersGetList()
    {
        $client = $this->login();
        $token = json_decode($client->getResponse()->getContent())->token;
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));
        $client->setServerParameter('CONTENT_TYPE', 'application/json');
        $client->setServerParameter('HTTP_ACCEPT', 'application/json');
        $client->request(
            'GET',
            '/api/customers/list',
            );
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

    }

    public function testCustomerGetById()
    {
        $client = $this->login();
        $token = json_decode($client->getResponse()->getContent())->token;
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));
        $client->setServerParameter('CONTENT_TYPE', 'application/json');
        $client->setServerParameter('HTTP_ACCEPT', 'application/json');
        $client->request(
            'GET',
            '/api/customers/1',
            );
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

    }
}
