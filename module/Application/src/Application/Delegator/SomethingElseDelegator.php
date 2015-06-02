<?php
namespace Application\Delegator;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\DelegatorFactoryInterface;

class SomethingElseDelegator implements DelegatorFactoryInterface
{
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        // $instance = call_user_func($callback);
        $instance = $callback();
        //echo '<br>delegator return';
        $instance->setSomethingElse('delegator-whatever');
        return $instance;
    }
}