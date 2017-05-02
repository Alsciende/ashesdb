<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Dice;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Description of DiceController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DiceController extends \AppBundle\Controller\API\BaseApiController
{
    /**
     * Get all Dices
     * 
     * @ApiDoc(
     *  resource=true,
     *  output="AppBundle\Entity\Dice",
     *  section="Dices",
     * )
     * @Route("/dices")
     * @Method("GET")
     */
    public function getAction ()
    {
        $dices = $this->getDoctrine()->getRepository(\AppBundle\Entity\Dice::class)->findAll();
        return $this->success($dices);
    }
}
