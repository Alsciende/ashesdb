<?php

namespace Tests\AlsciendeSecurityBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of AuthTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class AuthTest extends WebTestCase
{

    public function testGetIndex ()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );
    }

    public function testGetProfileFailure ()
    {
        $client = static::createClient();

        $client->request('GET', '/profile');
        $this->assertEquals(
                302, $client->getResponse()->getStatusCode()
        );
    }

    public function testGetProfileSuccess ()
    {
        $client = static::createClient(array(), array(
                    'PHP_AUTH_USER' => 'admin',
                    'PHP_AUTH_PW' => 'admin',
        ));

        $client->request('GET', '/profile');
        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );
    }

    public function testGetPublicApiAnonSuccess ()
    {
        $client = static::createClient();

        $client->request('GET', '/api/public', array());
        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(
                $response['success']
        );
        $this->assertArrayNotHasKey(
                'user', $response
        );
    }

    public function testGetPublicApiAuthSuccess ()
    {
        $client = static::createClient();

        $client->request('GET', '/api/public', array(), array(), array('HTTP_X-Access-Token' => "admin-access-token"));
        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(
                $response['success']
        );
        $this->assertArrayHasKey(
                'user', $response
        );
        $this->assertEquals(
                'admin', $response['user']
        );
    }

    public function testGetPrivateApiAnonFailure ()
    {
        $client = static::createClient();

        $client->request('GET', '/api/private', array());
        $this->assertEquals(
                401, $client->getResponse()->getStatusCode()
        );
    }

    public function testGetPrivateApiAuthSuccess ()
    {
        $client = static::createClient();

        $client->request('GET', '/api/private', array(), array(), array('HTTP_X-Access-Token' => "admin-access-token"));
        $this->assertEquals(
                200, $client->getResponse()->getStatusCode()
        );
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(
                $response['success']
        );
        $this->assertArrayHasKey(
                'user', $response
        );
        $this->assertEquals(
                'admin', $response['user']
        );
    }

}
