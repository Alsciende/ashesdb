<?php

namespace AppBundle\Controller\API\v1;

use AppBundle\Controller\API\BaseApiController;
use AppBundle\Entity\Deck;
use AppBundle\Manager\DeckManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * decks
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class PrivateDecksController extends BaseApiController
{

    /**
     * Create a private deck in initial version (0.1)
     * 
     * @ApiDoc(
     *  resource=true,
     *  section="Decks",
     * )
     * @Route("/private_decks")
     * @Method("POST")
     * @Security("has_role('ROLE_USER')")
     */
    public function postAction (Request $request)
    {
        $data = json_decode($request->getContent(), TRUE);
        
        /* @var $manager DeckManager */
        $manager = $this->get('app.deck_manager');
        try {
            $deck = $manager->createNewInitialDeck($data, $this->getUser());
        } catch (Exception $ex) {
            return $this->failure($ex->getMessage());
        }

        return $this->success($deck);
    }

    /**
     * Get all private decks
     * 
     * @ApiDoc(
     *  resource=true,
     *  section="Decks",
     * )
     * @Route("/private_decks")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function listAction ()
    {
        $decks = $this->getDoctrine()->getRepository(Deck::class)->findBy(['user' => $this->getUser()]);
        return $this->success($decks);
    }

}
