<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of CycleControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CycleControllerTest extends BaseApiControllerTest
{

    public function testGetCycles ()
    {
        $client = $this->getAnonymousClient();
        $this->assertStandardGetMany($client, "/api/v1/cycles");
    }

}
