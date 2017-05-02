<?php

namespace AppBundle\Repository;

/**
 * CardRepository
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class CardRepository extends \Doctrine\ORM\EntityRepository
{
    public function filter(\AppBundle\Model\CardQuery $query)
    {
        
    }
}
