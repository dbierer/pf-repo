<?php
namespace Application\Listeners;
use Application\Entity\Prospects;
use Doctrine\ORM\Event\PreUpdateEventArgs;
class ProspectsListener
{
    public function preUpdate(Prospects $prospect, PreUpdateEventArgs $event)
    {
        $status = $prospect->getStatus();
        $update = ($status) ? (int) substr($status, 7) : 0;
        $prospect->setStatus(sprintf('UPDATE:%02d', ++$update));
    }    
}
