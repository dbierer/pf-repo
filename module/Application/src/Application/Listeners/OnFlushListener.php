<?php
namespace Application\Listeners;

use Application\Listeners\DoctrineListener;
use Zend\EventManager\EventManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

// example of an event listener
class OnFlushListener 
{
    
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = new EventManager(DoctrineListener::EVENT_DOCTRINE_IDENTIFIER);
        $em->trigger(DoctrineListener::EVENT_DOCTRINE_ON_FLUSH, $this, array('onFlushEventArgs' => $args));
    }    
    
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $em = new EventManager(DoctrineListener::EVENT_DOCTRINE_IDENTIFIER);
        $em->trigger(DoctrineListener::EVENT_DOCTRINE_PRE_UPDATE, $this, array('onFlushEventArgs' => $args));
    }
    
}
