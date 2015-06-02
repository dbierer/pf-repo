<?php
namespace Application\Listeners;

use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Events;
use Doctrine\Common\EventSubscriber;

class DemoListener implements EventSubscriber
{
    /**
     * @param \Doctrine\DBAL\Event\ConnectionEventArgs $args
     *
     * @return void
     */
    public function postConnect(ConnectionEventArgs $args)
    {
        echo '---------------------------------------------------------' . PHP_EOL;
        echo 'LISTENER: ' . __METHOD__ . PHP_EOL;
        echo '---------------------------------------------------------' . PHP_EOL;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(Events::postConnect);
    }
}
