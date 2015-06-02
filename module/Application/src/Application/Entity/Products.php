<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity("Application\Entity\Products")
 * @ORM\Table("products")
 */
class Products
{
    /**
     * @ORM\Column(type="integer", length=11)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=16, nullable=true, unique=true)
     */
    protected $sku;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=4096, nullable=true)
     */
    protected $description;
    
    /**
    * @ORM\Column(type="decimal",precision=10,scale=2)
    */
    protected $price;
    
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $special;
    
    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $link;

    /**
     * many purchases:one product
     * @ORM\OneToMany(targetEntity="Application\Entity\Purchases", mappedBy="product")
     */
	protected $purchases;

    /**
     * many customers:many products
     * NOTE: you don't need to specify "inversedBy" as both sides could be considering "inverse"
     * @ORM\ManyToMany(targetEntity="Application\Entity\Customer", inversedBy="products")
     * @ORM\JoinTable(name="products_customers",
     *      joinColumns={@ORM\JoinColumn(name="customers_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="products_id", referencedColumnName="id")}
     *      )    
    */    
    protected $customers;
    
	/**
	 * Allows for many customers
	 */
	public function __construct() {
		parent::__construct();
		$this->customers = new ArrayCollection();
	}

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $sku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return the $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return the $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return the $special
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * @return the $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return the $purchases
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * @param field_type $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param number $special
     */
    public function setSpecial($special)
    {
        $this->special = $special;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @param field_type $purchases
     */
    public function setPurchases($purchases)
    {
        $this->purchases = $purchases;
    }

    /**
     * @return the $customers
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * Adds multiple customers for this product
     */
    public function setCustomers($customer)
    {
        $this->customers[] = $customer;
    }

}
