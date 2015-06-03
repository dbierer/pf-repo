<?php
namespace Application\Listeners;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * @author doug@unlikelysource.com
 */
class DoctrineListener implements ListenerAggregateInterface
{
    
    const EVENT_DOCTRINE_ON_FLUSH   = 'event.doctrine.onFlush';
    const EVENT_DOCTRINE_PRE_UPDATE = 'event.doctrine.preUpdate';
    const EVENT_DOCTRINE_IDENTIFIER = 'event.doctrine.identifier';
    
    use ListenerAggregateTrait;

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $event)
    {
        $this->listeners[] = $event->getSharedManager()->attach(
            self::EVENT_DOCTRINE_IDENTIFIER,
            self::EVENT_DOCTRINE_ON_FLUSH,
            [$this, 'onFlush']
        );
    }

    /**
     * Doctrine onFlush event
     *
     * @param ??? $e
     */
    public function onFlush($e)
    {
    
        $args = $e->getParam('onFlushEventArgs');
        $output = '<pre><b>' . date('Y-m-d H:i:s') . '</b>' . PHP_EOL;
        $output .= __FILE__ . PHP_EOL;
        $output .= sprintf("%12s:%8s:%30s\n", 
                            'Type', 
                            'ID',
                            'Class');
        $output .= sprintf("%12s:%8s:%30s\n", 
                            '----', 
                            '--',
                            '-----');
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $output .= sprintf("%12s:%8d:%30s\n", 
                                'INSERTION', 
                                $entity->getId(),
                                get_class($entity));
        }
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $output .= sprintf("%12s:%8d:%30s\n", 
                                'UPDATE', 
                                $entity->getId(),
                                get_class($entity));
        }
        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            $output .= sprintf("%12s:%8d:%30s\n", 
                                'DELETION', 
                                $entity->getId(),
                                get_class($entity));
        }
        $output .= '</pre>' . PHP_EOL;
        echo $output;
    }    
    
}
