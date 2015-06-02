<?php
namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Repository\CustomerRepo;

class RepoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $em = $sm->get('doctrine.entitymanager.orm_default');
        return new CustomerRepo($em, $em->getClassMetaData('Application\Entity\Customer'));        
    }
} 