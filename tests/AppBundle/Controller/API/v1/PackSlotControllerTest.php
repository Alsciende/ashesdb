<?php

namespace Tests\AppBundle\Controller\API\v1;

use Symfony\Component\HttpFoundation\Response;
use Tests\AppBundle\Controller\API\BaseApiControllerTest;

/**
 * Description of PackSlotControllerTest
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PackSlotControllerTest extends BaseApiControllerTest
{

    public function testGetPackSlots ()
    {
        $client = $this->getAnonymousClient();
        $client->request('GET', "/api/v1/pack_slots");
        $this->assertStandardGetMany($client);
    }

}
