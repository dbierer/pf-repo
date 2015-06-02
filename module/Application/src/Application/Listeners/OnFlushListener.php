<?php
namespace Application\Listeners;

use Doctrine\ORM\Event\OnFlushEventArgs;
use Application\Listeners\DoctrineListener;
use Zend\EventManager\EventManager;

// example of an event listener
class OnFlushListener 
{
    
    protected $logFile;
    
    public function __construct()
    {
        $this->logFile = __DIR__ . '/../../data/logs/on_flush_listener.log';
    }
    
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = new EventManager(DoctrineListener::EVENT_DOCTRINE_IDENTIFIER);
        $em->trigger(DoctrineListener::EVENT_DOCTRINE_ON_FLUSH, $this, array('onFlushEventArgs' => $args));
    }    
    
    public function dumpLog()
    {
        return file_get_contents($this->logFile);
    }
    
}
