<?php

namespace AppBundle\DataFixtures\ORM;

use Alsciende\SecurityBundle\Entity\Client;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of LoadSourceData
 *
 * @author Alsciende <alsciende@icloud.com>
 */
class LoadSourceData extends AbstractFixture implements OrderedFixtureInterface, \Symfony\Component\DependencyInjection\ContainerAwareInterface
{

    use  \Symfony\Component\DependencyInjection\ContainerAwareTrait;
    
    public function load (ObjectManager $manager)
    {
        /* @var $scanningService \Alsciende\SerializerBundle\Service\ScanningService */
        $scanningService = $this->container->get('alsciende_serializer.scanning_service');

        $sources = $scanningService->findSources();

        /* @var $serializer \Alsciende\SerializerBundle\Serializer\Serializer */
        $serializer = $this->container->get('alsciende_serializer.serializer');

        /* @var $validator \Symfony\Component\Validator\Validator\RecursiveValidator */
        $validator = $this->container->get('validator');

        foreach($sources as $source) {
            $result = $serializer->importSource($source);
            foreach($result as $imported) {
                $entity = $imported['entity'];
                $errors = $validator->validate($entity);
                if(count($errors) > 0) {
                    $errorsString = (string) $errors;
                    throw new \Exception($errorsString);
                }
            }

            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 3;
    }
}
