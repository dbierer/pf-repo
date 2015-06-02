<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Entity\Customer;
use Application\Entity\Profile;
use Application\Entity\Purchases;
use Zend\Stdlib\Hydrator\ClassMethods;
use Doctrine\Common\Util\Debug;

class CustomerRepo extends EntityRepository
{
    protected $hydrator;
    
    public function getEntityManager()
    {
        return parent::getEntityManager();
    }
    public function hydrateProfile(Customer $customer)
    {
        $data = $customer->getProfile();
        if (is_array($data)) {
            $customer->setProfile($this->getHydrator()->hydrate($data, new Profile()));
        }
        return $customer;
    }
    public function hydratePurchases(Customer $customer)
    {
        $x = 0;
        $data = $customer->getPurchases();
        foreach ($data as $purchase) {
            $customer->setOnePurchase($this->getHydrator()->hydrate($purchase, new Purchases()), $x++);
        }
        return $customer;
    }
    public function getHydrator()
    {
        if (!$this->hydrator) {
            $this->hydrator = new ClassMethods();
        }
        return $this->hydrator;
    } 
}