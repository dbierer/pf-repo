<?php
namespace Application\Service;

use Application\Entity\Customer;
use Zend\Form\Form;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;

class CustomerService
{
    const DEFAULT_PERSON_IMAGE = '/img/msewtz_Business_Person.png';
    const DEFAULT_WIDTH     = 400;
    const DEFAULT_HEIGHT    = 200;
    
    /**
     * Displays customer + profile info
     * @param Application\Entity\Customer $customer
     * @param string $message
     * @return string $output HTML
     */
    public function showCustInfo(Customer $customer, $message)
    {
        // NOTE: multiple calls to $customer->getProfile() *does not* generate additional SQL queries!
        $photo = $customer->getProfile()->getPhoto();
        $photo = ($photo) ?: self::DEFAULT_PERSON_IMAGE;
        $output = '<br>';
        $output .= "<h3>{$message}</h3>\n";
        $output .= '<hr>';
        $output .= "<style>\n";
        $output .= "td { width: " . self::DEFAULT_WIDTH . "px; border: thin solid gray; }\n";
        $output .= "</style>\n";
        $output .= "<table>\n";
        $output .= "<tr><td style='text-align:center;'><img src='{$photo}' height='" . self::DEFAULT_HEIGHT . "'></td>\n";
        $output .= "<td><ul>";
        $output .= "<li>{$customer->getName()}</li>\n";
        $output .= "<li>{$customer->getEmail()}</li>\n";
        $output .= "<li>{$customer->getProfile()->getAddress()}</li>\n";
        $output .= "<li>{$customer->getProfile()->getCity()}</li>\n";
        $output .= "<li>{$customer->getProfile()->getState_province()}</li>\n";
        $output .= "<li>{$customer->getProfile()->getPostal_code()}</li>\n";
        $output .= "<li>{$customer->getProfile()->getPhone()}</li>\n";
        $output .= "<li>" . number_format($customer->getBalance(),2) . "</li>\n";
        $output .= "</ul></td></tr>\n";
        $output .= "</table>\n";
        return $output;
    }

    /**
     * Displays customer info
     * @param array(Application\Entity\Customer $customer)
     * @return string $output HTML
     */
    public function showAllCustInfo($customerList)
    {
        $output = '';
        $output .= '<hr>';
        $output .= "<style>\n";
        $output .= "td { width: 100px; border: thin solid gray; }\n";
        $output .= "</style>\n";
        $output .= "<table>\n";
        $output .= "<tr><th>&nbsp;</th><th>Name</th><th>Address</th><th>City</th><th></th><th>PostCode</th><th>Phone</th><th>Balance</th></tr>\n";
        foreach ($customerList as $customer) {
            $output .= $this->showCustLineInfo($customer);
        }
        $output .= "</table>\n";
        return $output;
    }
    
    /**
     * Displays customer + profile info in line by line format
     * @param Application\Entity\Customer $customer
     * @return string $output HTML
     */
    public function showCustLineInfo(Customer $customer)
    {
        // NOTE: multiple calls to $customer->getProfile() *does not* generate additional SQL queries!
        $output = '';
        $output .= "<tr>\n";
        $output .= "<td style='font-size: 9pt;'>{$customer->getName()}</td>\n";
        $output .= "<td style='font-size: 9pt;'>{$customer->getEmail()}</td>\n";
        $output .= "<td style='font-size: 9pt; width:200px; '>{$customer->getProfile()->getAddress()}</td>\n";
        $output .= "<td style='font-size: 9pt;'>{$customer->getProfile()->getCity()}</td>\n";
        $output .= "<td style='font-size: 9pt;'>{$customer->getProfile()->getState_province()}</td>\n";
        $output .= "<td style='font-size: 9pt;'>{$customer->getProfile()->getPostal_code()}</td>\n";
        $output .= "<td style='font-size: 9pt;'>{$customer->getProfile()->getPhone()}</td>\n";
        $output .= "<td style='font-size: 9pt;'>" . number_format($customer->getBalance(),2) . "</td>\n";
        $output .= "</tr>\n";
        return $output;
    }

    /**
     * Returns <form> which allows for customer and product selection
     * 
     * @param string $custSelect HTML SELECT element
     * @param string $prodSelect HTML SELECT element
     * @param string $extraInput HTML
     * @param bool $header == TRUE = show links
     * @return string HTML FORM
     */
    public function selectForm($list, $custId)
    {
        $form = new Form('customer');
        $form->setAttribute('method', 'post');
        $select = new Select('custId');
        $select->setLabel('Customers and Purchases')
               ->setValueOptions($this->getCustomerArray($list))
               ->setUnselectedValue('Choose')
               ->setValue($custId);
        $submit = new Submit('submit');
        $submit->setValue('Choose');
        $form->add($select)
             ->add($submit);
        return $form;
    }
        
    /**
     * Returns an HTML SELECT element
     * @param array (Application\Entity\Customer $customerList)
     * @param int $custId
     * @return string HTML
     */
    public function getCustomerArray($customerList)
    {
        $list = array();
        foreach ($customerList as $customer) {
            $list[$customer->getId()] = $customer->getName(); 
        }
        return $list;
    }

}
