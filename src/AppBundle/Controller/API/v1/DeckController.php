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
 * Description of DeckController
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckController extends BaseApiController
{
    
    /**
     * Update a public deck - only name and description can be updated
     * 
     * @ApiDoc(
     *  resource=true,
     *  section="Decks",
     * )
     * @Route("/decks/{id}")
     * @Method("PUT")
     * @Security("has_role('ROLE_USER')")
     */
    public function putAction (Request $request, Deck $deck)
    {
        if($deck->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $data = json_decode($request->getContent(), TRUE);
        
        /* @var $manager DeckManager */
        $manager = $this->get('app.deck_manager');
        try {
            $updated = $manager->update($data, $deck);
        } catch (Exception $ex) {
            return $this->failure($ex->getMessage());
        }

        return $this->success($updated);
    }
    
    
    /**
     * Get a deck (public or private)
     * 
     * @ApiDoc(
     *  resource=true,
     *  section="Decks",
     * )
     * @Route("/decks/{id}")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */
    public function getAction (Deck $deck)
    {
        if($deck->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }
        return $this->success($deck);
    }

    /**
     * Delete a deck (public or private). Other versions are untouched.
     * 
     * @ApiDoc(
     *  resource=true,
     *  section="Decks",
     * )
     * @Route("/decks/{id}")
     * @Method("DELETE")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction (Deck $deck)
    {
        if($deck->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        /* @var $manager DeckManager */
        $manager = $this->get('app.deck_manager');
        try {
            $manager->deleteDeck($deck);
        } catch (Exception $ex) {
            return $this->failure($ex->getMessage());
        }
        return new \Symfony\Component\HttpFoundation\Response();
    }

}
