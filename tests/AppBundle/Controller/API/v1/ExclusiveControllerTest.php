<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of ExclusiveControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ExclusiveControllerTest extends BaseApiControllerTest
{

    public function testGetExclusives ()
    {
        $client = $this->getAnonymousClient();
        $client->request('GET', "/api/v1/exclusives");
        $this->assertStandardGetMany($client);
    }

}
