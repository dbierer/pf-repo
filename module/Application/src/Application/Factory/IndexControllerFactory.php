<?php
namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $controller = new IndexController();
        $sm = $controllerManager->getServiceLocator();
        $controller->setTest($sm->get('application-test-service'));
        $controller->setFormAnnotation($sm->get('application-form-annotation'));
        $controller->setFormFieldset($sm->get('application-form-fieldset'));
        $controller->setCustomerEntity($sm->get('application-entity-customer'));
        $controller->setRepo($sm->get('application-repo-customer'));
        $controller->setService($sm->get('application-service-customer'));
        return $controller;
    }
} 