<?php
namespace Application\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

// @ORM\EntityListeners({"Application\Listeners\ProspectsListener"})
/**
 * @ORM\Entity("Application\Entity\Prospects")
 * @ORM\Table("prospects")
 * @ORM\HasLifecycleCallbacks
 * @ORM\NamedNativeQueries({
 *      @ORM\NamedNativeQuery(
 *          name         = "prospectsWhoLiveInSomeState",
 *          resultClass  = "Application\Entity\Prospects",
 *          query        = "SELECT * FROM prospects p WHERE p.state_province = :state ORDER BY p.last_name ASC, p.first_name ASC"
 *      ),
 * })
 * // NOTE: the result set below is not used, but is here as an example
 * //       which would have needed resultSetMapping= "mappingProspectByState" to be set on line 17
 * @ORM\SqlResultSetMappings({
 *      @ORM\SqlResultSetMapping(
 *          name    = "mappingProspectByState",
 *          entities= {
 *              @ORM\EntityResult(
 *                  entityClass = "__CLASS__",
 *                  fields      = {
 *                      @ORM\FieldResult(name = "id",            column="p.id"),
 *                      @ORM\FieldResult(name = "firstName",     column="p.first_name"),
 *                      @ORM\FieldResult(name = "lastName",      column="p.last_name"),
 *                      @ORM\FieldResult(name = "email",         column="p.email"),
 *                      @ORM\FieldResult(name = "stateProvince", column="p.state_province"),
 *                      @ORM\FieldResult(name = "postalCode",    column="p.postal_code"),
 *                  }),
 *          },
 *      ),
 *}) 
 */
class Prospects
{
    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        echo PHP_EOL . '---------------------------------------';
        echo PHP_EOL . __METHOD__;
        echo PHP_EOL . 'Update the "status" field';
        echo PHP_EOL . '---------------------------------------';
        $this->setLastUpdated(new DateTime('now'));
    }
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id; 	
    
    /**
     * @ORM\Column(type="string", length=128, name="first_name")
     */
    protected $firstName; 
    
    /**
     * @ORM\Column(type="string", length=128, name="last_name")
     */
    protected $lastName; 
    
    /**
     * @ORM\Column(type="string", length=250, unique=true)
     */
    protected $email; 	
    
    /**
     * @ORM\Column(type="string", length=256, nullable=true)
     */
    protected $address;
     	
    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $city; 	
    
    /**
     * @ORM\Column(type="string", length=32, name="state_province", nullable=true)
     */
    protected $stateProvince; 	
    
    /**
     * @ORM\Column(type="string", length=16, name="postal_code", options={"fixed":true})
     */
    protected $postalCode; 	
    
    /**
     * @ORM\Column(type="string", length=16)
     */
    protected $phone; 	
    
    /**
     * @ORM\Column(type="string", length=2, options={"fixed":true})
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=8, options={"fixed":true}, nullable=true)
     */
    protected $status; 	    
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    protected $budget; 	    

    /**
     * @ORM\Column(type="datetime", name="last_updated", nullable=true)
     */
    protected $lastUpdated; 	    

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return the $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return the $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return the $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return the $stateProvince
     */
    public function getStateProvince()
    {
        return $this->stateProvince;
    }

    /**
     * @return the $postalCode
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return the $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return the $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param field_type $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param field_type $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param field_type $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param field_type $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param field_type $stateProvince
     */
    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;
    }

    /**
     * @param field_type $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @param field_type $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param field_type $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return the $budget
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param field_type $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param field_type $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * Returns first and last names
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function setLastUpdated($date)
    {
        $this->lastUpdated = $date;
    }
    
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }
 }
