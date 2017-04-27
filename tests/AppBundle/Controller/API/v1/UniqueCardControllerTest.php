<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of UniqueCardControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class UniqueCardControllerTest extends BaseApiControllerTest
{

    public function testGetUniqueCards ()
    {
        $client = $this->getAnonymousClient();
        $this->assertStandardGetMany($client, "/api/v1/unique_cards");
    }

}
