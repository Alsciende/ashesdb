<?php

namespace Tests\AlsciendeSecurityBundle;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Alsciende\SecurityBundle\Service\UserManager;
use FOS\OAuthServerBundle\Model\AccessTokenManagerInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;

/**
 * Description of AuthTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class AuthTest extends WebTestCase
{

    /** @var AccessTokenManagerInterface */
    private $accessTokenManager;

    /** @var ClientManagerInterface */
    private $clientManager;

    /** @var UserManager */
    private $userManager;

    protected function setUp ()
    {
        self::bootKernel();

        $this->accessTokenManager = static::$kernel->getContainer()
                ->get('fos_oauth_server.access_token_manager');

        $this->clientManager = static::$kernel->getContainer()
                ->get('fos_oauth_server.client_manager');

        $this->userManager = static::$kernel->getContainer()
                ->get('alsciende_security.user_manager');
    }

    protected function tearDown ()
    {
        parent::tearDown();
        $this->accessTokenManager = null;
        $this->clientManager = null;
        $this->userManager = null;
    }

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

        $token = $this->accessTokenManager->findTokenBy([]);
        $client->request('GET', '/api/public', array(), array(), array('HTTP_X-Access-Token' => $token->getToken()));
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

        $token = $this->accessTokenManager->findTokenBy([]);
        $client->request('GET', '/api/private', array(), array(), array('HTTP_X-Access-Token' => $token->getToken()));
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
