<?php
namespace Application\Forms;

use Zend\Form\Fieldset;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\InputFilter\InputProviderInterface;
use Application\Entity\Purchases as PurchasesEntity;

class Purchases extends Fieldset implements InputProviderInterface
{

    public function init()
    {
        parent::setName('purchases');
        
            $this->setHydrator(new ClassMethods())
             ->setObject(new PurchasesEntity());
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'transaction[]',
            'options' => array(
                'label' => 'Transaction'
            ),    
        ));
        
        // etc.
        
        // you could add fieldsets here, or inject them in the factory
        
    }
    
    public function getInputSpecification()
    {
        return array(
            array(
                'name' => 'transaction',
                'required' => true,
                'filters' => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                    array('name' => 'Zend\Filter\StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 8)),
                    array('name' => 'Alnum'),
                ),
            ),
            // etc.
        );
    }

}