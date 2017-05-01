<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Private decks
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
class PrivateDeckController extends BaseApiController
{
    /**
     * Create a new private deck in version 0.1
     * 
     * @ApiDoc(
     *  resource=true,
     *  section="Private Decks",
     * )
     * @Route("/decks")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function postAction (Request $request)
    {
        /* @var $manager \AppBundle\Manager\DeckManager */
        $manager = $this->get('app.deck_manager');
        try {
            $deck = $manager->create($request->request->all(), $this->getUser());
        } catch (\Exception $ex) {
            return $this->failure($ex->getMessage());
        }
        
        return $this->success($deck);
    }
}
