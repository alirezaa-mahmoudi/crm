<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerTest extends WebTestCase
{
    public function login()
    {
        $client = self::createClient();
        $client->setServerParameter('CONTENT_TYPE', 'application/json');
        $client->setServerParameter('HTTP_ACCEPT', 'application/json');
        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"username":"admin@admin.com", "password":"admin123456"}'
        );
        $token = json_decode($client->getResponse()->getContent())->token;
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token));

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
        $client->request('GET', '/api/customers/list');
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testCustomersUrl()
    {
        $client = $this->login();
        $client->request(
            'GET',
            '/api/customers/list',
        );
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCustomersGetList()
    {
        $client = $this->login();
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
        $client->request(
            'GET',
            '/api/customers/1',
            );
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCustomerPostDeleteMethod()
    {
        $client = $this->login();
        $client->request('POST', '/api/customers/create', [], [], [],
            '{
    	                "email": "test@test.com",
    	                "company":"bmw",
    	                "phone": "017628245872",
    	                "country": "Germany",
    	                "firstName": "alireza",
    	                "lastName": "Mahmoudi",
                	    "street": "Kreuzberg",
                        "city": "Berlin",
                	    "zip": "34645456"
                    }'
        );
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $customerId = json_decode($client->getResponse()->getContent())->id;
        $client->request('DELETE', '/api/customers/delete/'.$customerId);
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testCustomerPutMethod()
    {
        $client = $this->login();
        $client->request('PUT', '/api/customers/update/10', [], [], [],
            '{	
	                "country": "Iran"
                    }'
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('Iran', json_decode($client->getResponse()->getContent())->country);
    }
}
