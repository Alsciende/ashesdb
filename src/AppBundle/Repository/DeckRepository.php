<?php

namespace AppBundle\Repository;

/**
 * Description of DeckRepository
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class DeckRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Remove all private decks of a lineage
     * 
     * @param string $lineage
     */
    public function removeLineage(string $lineage, User $user)
    {
        $decks = $this->findByLineage($lineage, $user);
        foreach($decks as $deck) {
            $this->getEntityManager()->remove($deck);
        }
    }
    
    /**
     * Return the last private deck of a lineage
     * @param string $lineage
     * @return type
     */
    public function getLastMinorVersion(string $lineage, User $user)
    {
        $decks = $this->findByLineage($lineage, $user);
        if(count($decks)) {
            return $decks[0];
        }
    }
    
    /**
     * Return all private decks of a lineage
     * 
     * @param string $lineage
     * @return type
     */
    public function findByLineage(string $lineage, User $user)
    {
        return $this->findBy(['lineage' => $lineage, 'user' => $user, 'isPublished' => FALSE], ['createdAt' => 'DESC']);
    }
    
}
