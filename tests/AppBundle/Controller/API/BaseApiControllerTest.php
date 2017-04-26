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

    public function getContent(\Symfony\Bundle\FrameworkBundle\Client $client)
    {
        return json_decode($client->getResponse()->getContent(), true);
    }
    
    public function getAccessToken()
    {
        $token = $this->accessTokenManager->findTokenBy([]);
        return $token->getToken();
    }
    
}
