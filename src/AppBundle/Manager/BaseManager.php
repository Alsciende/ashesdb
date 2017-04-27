<?php

namespace AppBundle\Manager;

/**
 * Description of BaseManage
 *
 * @author Alsciende <alsciende@icloud.com>
 */
abstract class BaseManager
{

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     *
     * @var \Symfony\Component\Serializer\Serializer
     */
    protected $serializer;

    public function __construct (\Doctrine\ORM\EntityManager $entityManager, \Symfony\Component\Serializer\Serializer $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * Writes a created entity to the database
     * 
     * @param object $entity
     * @return object
     */
    public function persist ($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }

    /**
     * Writes an updated entity to the database
     * 
     * @param object $entity
     * @return object
     */
    public function merge ($entity)
    {
        $merged = $this->entityManager->merge($entity);
        $this->entityManager->flush();
        return $merged;
    }

}
