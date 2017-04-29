<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of DeckController
 *
 * @author Cédric Bertolini <cedric.bertolini@proximedia.fr>
 */
class DeckController extends BaseApiController
{
    /**
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
