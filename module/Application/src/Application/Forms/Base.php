<?php
namespace Application\Form;

use Zend\Form\Fieldset;
class Base extends Fieldset
{
    public function init()
    {
        $this->add(array(
            'type' => 'Submit',
            'name' => 'submit',
        ));
    }
}