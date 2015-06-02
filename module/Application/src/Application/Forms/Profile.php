<?php
namespace Application\Forms;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Application\Entity\Profile as ProfileEntity;

class Profile extends Fieldset implements InputProviderInterface
{
    
    public function init()
    {
        parent::setName('profile');
        
        $this->setHydrator(new ClassMethods())
             ->setObject(new ProfileEntity());
        
        $this->add(array(
            'type' => 'Text',
            'name' => 'address',
            'options' => array(
                'label' => 'Address'
            ),    
        ));
        
        // etc.
    }
    
    public function getInputSpecification()
    {
        return array(
            array(
                'name' => 'address',
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