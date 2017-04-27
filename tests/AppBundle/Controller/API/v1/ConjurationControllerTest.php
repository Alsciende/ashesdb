<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of ConjurationControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class ConjurationControllerTest extends BaseApiControllerTest
{

    public function testGetConjurations ()
    {
        $client = $this->getAnonymousClient();
        $this->assertStandardGetMany($client, "/api/v1/conjurations");
    }

}
