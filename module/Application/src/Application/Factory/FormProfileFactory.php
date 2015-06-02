<?php
namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Forms\Profile;

class FormProfileFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        // build form
        $form = new Profile();
        $form->init();
        // $form->setTranslator(xxx)
        return $form;
    }
} 