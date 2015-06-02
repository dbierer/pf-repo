<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation as ANO;

/**
 * @ORM\Entity("Application\Entity\Purchases")
 * @ORM\Table("purchases")
 */
class Purchases
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
     * @ANO\Options({"label":"Transaction Number"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"StringLength", "options":{ "max":"8"}})
     * @ANO\Validator({ "name":"Alnum"})
     * @ORM\Column(type="string", length=8)
     */
	protected $transaction;

    /**
     * many products:1 purchase
     * @ANO\Exclude
     * @ORM\ManyToOne(targetEntity="Application\Entity\Products", inversedBy="purchases")
     */
	protected $product;

    /**
     * many purchases:1 customer
     * @ANO\Exclude
     * @ORM\ManyToOne(targetEntity="Application\Entity\Customer", inversedBy="purchases")
     */
	protected $customer;

    /**
     * @ANO\Type("Zend\Form\Element\Date")
     * @ANO\Options({"label":"Purchase Date"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"Date"})
     * @ORM\Column(type="datetime")
     */
	protected $date;

    /**
     * @ANO\Type("Zend\Form\Element\Number")
     * @ANO\Options({"label":"Quantity"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"Digits"})
     * @ORM\Column(type="integer", length=6, options={"unsigned":true})
     */
	protected $quantity;

    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"Sale Price"})
     * @ANO\Attributes({"title":"Please enter the price at the time of the sale"})
     * @ANO\Required(true)
     * @ANO\Validator({"name":"Float"})
     * @ANO\Validator({"name":"Regex", "options":{"pattern":"/^\d+(\.\d{2})?$/"}})
    * @ORM\Column(type="decimal", precision=8, scale=2, name="sale_price")
    */
	protected $salePrice;
    
	/**
	 * Initializes the entity variable.
	 */
	public function __construct() 
	{
		$this->products = new ArrayCollection();
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

    /**
     * @return the $transaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * @param field_type $transaction
     */
    public function setTransaction($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return the $product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param field_type $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return the $customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param field_type $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return the $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param field_type $date
     */
    public function setDate($date)
    {
        if (is_string($date)) $date = new \DateTime($date);            
        $this->date = $date;
    }

    /**
     * @return the $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param field_type $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return the $salePrice
     */
    public function getSalePrice()
    {
        return $this->salePrice;
    }

    /**
     * @param field_type $salePrice
     */
    public function setSalePrice($salePrice)
    {
        $this->salePrice = $salePrice;
    }

    /*
     * Returns sale price * qty
     */
    public function getTotal()
    {
        return $this->salePrice * $this->quantity;
    }

}
