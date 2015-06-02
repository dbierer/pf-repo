<?php
namespace Application\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Service\TestServiceInterface;

class SomethingElseInitializer implements InitializerInterface
//class SomethingElseInitializer
{
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        echo '<br>' . get_class($instance);
        if ($instance instanceof TestServiceInterface) {
            $instance->setSomethingElse('whatever');
        }
        
    }
}