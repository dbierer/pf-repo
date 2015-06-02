<?php
namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\Element\Submit;
use Application\Forms\Customer;
use Zend\Stdlib\Hydrator\ClassMethods;

class FormFieldsetFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        // build form
        $form = new Customer('customer');
        $form->setAttribute('method', 'post');
        $form->init();
        $form->setHydrator(new ClassMethods());
        // add fieldsets to form
        $form->add($sm->get('ProfileFieldset'));
        $form->add($sm->get('PurchasesFieldset'));
        /*
         * TODO
        $fieldSet2 = $sm->get('PurchasesFieldset');
        $fieldSet2->get('transaction')->setName('trans2');
        $form->add($fieldSet2);
        */
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