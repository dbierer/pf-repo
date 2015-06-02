<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as ANO;

/**
 * @ANO\Name("profile")
 * @ANO\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @ORM\Entity("Application\Entity\Profile")
 * @ORM\Table("profile")
 */
class Profile
{
    /**
     * @ANO\Exclude
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     	
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"Address"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"StringLength", "options":{ "max":"256"}})
     * @ORM\Column(type="string", length=256)
     */
    protected $address;
     	
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"City"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"StringLength", "options":{ "max":"256"}})
     * @ORM\Column(type="string", length=64)
     */
    protected $city; 	
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"State/Province"})
     * @ANO\AllowEmpty(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"StringLength", "options":{ "max":"32"}})
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    protected $state_province; 	
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"Postal Code"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"StringLength", "options":{ "max":"32"}})
     * @ORM\Column(type="string", length=10)
     */
    protected $postal_code; 	
    
    /**
     * @ANO\Type("Zend\Form\Element\Select")
     * @ANO\Options({"label":"Country"})
     * @ANO\AllowEmpty(true)
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Filter({"name":"StringToUpper"})
     * @ANO\Attributes({"options":{"ARE":"United Arab Emirates","BRA":"Brazil","EGY":"Egypt","IND":"India","SWZ":"Switzerland","RUS":"Russia","THA":"Thailand","USA":"United States"}})
     * @ANO\Validator({"name":"InArray", "options":{"haystack":{"ARE","BRA","EGY","IND","SWZ","RUS","THA","USA"}}})
     * @ORM\Column(type="string", length=3)
     */
    protected $country; 	
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"Phone"})
     * @ANO\AllowEmpty(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({"name":"Regex", "options":{"pattern":"/^\d+((-)?\d+)*$/i"}})
     * @ANO\Validator({ "name":"StringLength", "options":{ "max":"16"}})
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    protected $phone; 	
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"City"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"StringLength", "options":{ "max":"256"}})
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $photo; 	
    
    /**
     * @ANO\Type("Zend\Form\Element\Date")
     * @ANO\Options({"label":"Date of Birth"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"Date"})
     * @ORM\Column(type="datetime")
     */
    protected $dob;
    
    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
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
     * @return the $state_province
     */
    public function getState_province()
    {
        return $this->state_province;
    }

    /**
     * @return the $postal_code
     */
    public function getPostal_code()
    {
        return $this->postal_code;
    }

    /**
     * @return the $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return the $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return the $photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @return the $dob
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param field_type $state_province
     */
    public function setState_province($state_province)
    {
        $this->state_province = $state_province;
    }

    /**
     * @param field_type $postal_code
     */
    public function setPostal_code($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @param field_type $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param field_type $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @param field_type $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @param field_type $dob
     */
    public function setDob($dob)
    {
        if (is_string($dob)) $dob = new \DateTime($dob);            
        $this->dob = $dob;
    }

    
}
