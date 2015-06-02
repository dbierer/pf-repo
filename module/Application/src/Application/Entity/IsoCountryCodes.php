<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity("Application\Entity\IsoCountryCodes")
 * @ORM\Table("iso_country_codes")
 */
class IsoCountryCodes
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=4, name="iso_numeric")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=2, options={"fixed":true})
     */
    protected $iso2;
    
    /**
     * @ORM\Column(type="string", length=3, options={"fixed":true})
     */
    protected $iso3;
    
    /**
     * @ORM\Column(type="string", length=32, name="iso_3166")
     */
    protected $iso3166;    
    
    /**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param field_type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return the $iso2
     */
    public function getIso2()
    {
        return $this->iso2;
    }

    /**
     * @param field_type $iso2
     */
    public function setIso2($iso2)
    {
        $this->iso2 = $iso2;
    }

    /**
     * @return the $iso3
     */
    public function getIso3()
    {
        return $this->iso3;
    }

    /**
     * @param field_type $iso3
     */
    public function setIso3($iso3)
    {
        $this->iso3 = $iso3;
    }

    /**
     * @return the $iso_3166
     */
    public function getIso3166()
    {
        return $this->iso3166;
    }

    /**
     * @param field_type $iso_3166
     */
    public function setIso3166($iso3166)
    {
        $this->iso3166 = $iso3166;
    }

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



}
