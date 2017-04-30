<?php

namespace Tests\AppBundle\Controller\API;

/**
 * Description of BaseApiControllerTest
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
abstract class BaseApiControllerTest extends \Tests\AppBundle\Controller\BaseControllerTest
{

    /** @var \FOS\OAuthServerBundle\Model\ClientManagerInterface */
    private $clientManager;

    /** @var \Alsciende\SecurityBundle\Service\UserManager */
    private $userManager;

    /** @var \FOS\OAuthServerBundle\Model\AccessTokenManagerInterface */
    private $accessTokenManager;

    protected function setUp ()
    {
        self::bootKernel();

        $this->clientManager = static::$kernel->getContainer()
                ->get('fos_oauth_server.client_manager');

        $this->userManager = static::$kernel->getContainer()
                ->get('alsciende_security.user_manager');

        $this->accessTokenManager = static::$kernel->getContainer()
                ->get('fos_oauth_server.access_token_manager');
    }

    public function getContent (\Symfony\Bundle\FrameworkBundle\Client $client)
    {
        return json_decode($client->getResponse()->getContent(), true);
    }

    /**
     * 
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public function getAuthenticatedClient ($username = 'user', $password = 'user')
    {
        $user = $this->userManager->findUserByUsername($username);
        $accessToken = $this->accessTokenManager->findTokenBy(['user' => $user]);
        return static::createClient(array(), array(
                    'HTTP_X-Access-Token' => $accessToken->getToken(),
        ));
    }

    public function assertStandardGetMany (\Symfony\Bundle\FrameworkBundle\Client $client)
    {
        $this->assertEquals(
                \Symfony\Component\HttpFoundation\Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertTrue(
                $content['success']
        );
        $this->assertGreaterThan(
                0, $content['size']
        );
        $this->assertEquals(
                $content['size'], count($content['records'])
        );
        return $content['records'];
    }

    public function assertStandardGetOne (\Symfony\Bundle\FrameworkBundle\Client $client)
    {
        $this->assertEquals(
                \Symfony\Component\HttpFoundation\Response::HTTP_OK, $client->getResponse()->getStatusCode()
        );
        $content = $this->getContent($client);
        $this->assertTrue(
                $content['success']
        );
        $this->assertArrayHasKey(
                'record', $content
        );
        return $content['record'];
    }

}
