<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Controller\IndexController;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function init(ModuleManager $e)
    {
        $eventManager = $e->getEventManager();
        $sharedManager = $eventManager->getSharedManager();
        //$sharedManager->attach('*', MvcEvent::EVENT_BOOTSTRAP, array($this, 'testListener'));       
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        //$sharedManager = $eventManager->getSharedManager();
        //$sharedManager->attach('Application\Controller\IndexController', IndexController::SOME_EVENT, array($this, 'testListener'));
    }

    public function testListener($e)
    {
        echo 'E:' . get_class($e) . ' : ' . $e->getName() . ' : ' . get_class($e->getTarget()) . ' : ';   
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
