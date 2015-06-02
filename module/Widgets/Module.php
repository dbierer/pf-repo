<?php
namespace Widgets;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleEvent;

class Module
{
    public function init(ModuleManager $e)
    {
        $em = $e->getEventManager();
        //$em->attach('*', array($this, 'moduleHandler'));
    }
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
    }
    public function moduleHandler($e)
    {
        echo '<br>HANDLER: ' . $e->getName() . ':' . get_class($e->getTarget());
    }
}