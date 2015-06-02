<?php
namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Element\Submit;

class FormAnnotationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        // build form
        $builder = new AnnotationBuilder();
        $form = $builder->createForm('Application\Entity\Customer');
        // $form->setTranslator(xxx)
        // add submit button
        $submit = new Submit('submit');
        $submit->setValue('Submit'); 
        $form->add($submit);
        // lookup countries
        // populate select field
        return $form;
    }
} 