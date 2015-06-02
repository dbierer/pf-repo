<?php
namespace Application\Forms;

use Zend\InputFilter\InputProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Entity\Customer as CustomerEntity;
use Zend\Form\Form;

class Customer extends Form implements InputProviderInterface
{

    // NOTE: DO NOT use __construct()!!!
    // See: http://zend-framework-community.634137.n4.nabble.com/Adding-custom-form-elements-td4659495.html
    //      post from bakura
    public function init()
    {
       
        $this->setHydrator(new ClassMethods())
             ->setObject(new CustomerEntity());
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'name',
            'options' => array(
                'label' => 'Name'
            ),    
        ));
        
    }
    
    public function getInputSpecification()
    {
        return array(
            array(
                'name' => 'name',
                'required' => true,
                'filters' => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                    array('name' => 'Zend\Filter\StripTags'),
                ),
                'validators' => array(
                    array('name' => 'StringLength', 'options' => array('max' => 256)),
                ),
            ),
            // etc.
        );
    }

}