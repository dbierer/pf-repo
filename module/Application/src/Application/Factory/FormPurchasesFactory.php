<?php
namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Forms\Purchases;

class FormPurchasesFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        // build form
        $form = new Purchases();
        $form->init();
        // $form->setTranslator(xxx)
        return $form;
    }
} 