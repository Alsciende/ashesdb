<?php

namespace Tests\AppBundle\Controller\API;

/**
 * Description of BaseApiControllerTest
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
abstract class BaseApiControllerTest extends \Tests\AppBundle\Controller\BaseControllerTest
{

    /** @var AccessTokenManagerInterface */
    private $accessTokenManager;

    protected function setUp ()
    {
        self::bootKernel();

        $this->accessTokenManager = static::$kernel->getContainer()
                ->get('fos_oauth_server.access_token_manager');
    }

    public function getContent (\Symfony\Bundle\FrameworkBundle\Client $client)
    {
        return json_decode($client->getResponse()->getContent(), true);
    }

    public function getAccessToken ()
    {
        $token = $this->accessTokenManager->findTokenBy([]);
        return $token->getToken();
    }

    /**
     * 
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    public function getAuthenticatedClient ($username = 'user', $password = 'user')
    {
        return static::createClient(array(), array(
                    'HTTP_X-Access-Token' => $this->getAccessToken(),
        ));
    }

    public function assertStandardGetMany (\Symfony\Bundle\FrameworkBundle\Client $client, string $url)
    {
        $client->request('GET', $url);
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
    }

}
