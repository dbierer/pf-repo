<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Form\Annotation as ANO;

/**
 * @ANO\Name("customer")
 * @ORM\HasLifecycleCallbacks
 * @ANO\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 * @ORM\Entity("Application\Entity\Customer")
 * @ORM\Table("customer")
 */
class Customer
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
     * @ANO\Options({"label":"Name"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Filter({"name":"StringTrim"})
     * @ANO\Validator({ "name":"StringLength", "options":{ "max":"256"}})
     * @ORM\Column(type="string", length=256)
     */
    protected $name; 
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"Balance"})
     * @ANO\Attributes({"title":"Please enter the amount owing"})
     * @ANO\Required(true)
     * @ANO\Validator({"name":"Float"})
     * @ANO\Validator({"name":"Regex", "options":{"pattern":"/^\d+(\.\d{2})?$/"}})
    * @ORM\Column(type="decimal",precision=10,scale=2)
     */
    protected $balance; 	    
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"Email"})
     * @ANO\Required(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Validator({"name":"EmailAddress"})
     * @ORM\Column(type="string", unique=true, length=250)
     */
    protected $email;    
    
    // (min 8 characters, upper and lowercase with numbers)
    /**
     * @ANO\Type("Zend\Form\Element\Password")
     * @ANO\Options({"label":"Password"})
     * @ANO\Required(true)
     * @ORM\Column(type="string", length=16, options={"fixed":true})
     */
    protected $password; 	
    
    /**
     * @ANO\Exclude()
     * @ORM\Column(type="integer", length=4, options={"unsigned":true, "default":0})
     */
    protected $status; 	    
    
    /**
     * @ANO\Type("Zend\Form\Element\Text")
     * @ANO\Options({"label":"Security Question - create a question only you know the answer to"})
     * @ANO\Attributes({"placeholder":"A security question prompt..."})
     * @ANO\AllowEmpty(true)
     * @ANO\Filter({"name":"StripTags"})
     * @ANO\Validator({ "name":"StringLength",
     *                  "options":{"max":"250"},
     *                  "name":"Alnum",
     *                  "options":{"allowWhiteSpace":"true"}})
     * @ORM\Column(type="string", length=250, name="security_question", nullable=true)
     */
	protected $securityQuestion;
	
    /**
     * @ANO\Exclude
     * @ORM\Column(type="string", length=32, name="confirm_code", nullable=true)
     */
	protected $confirmCode; 	

	// NOTE: need to add cascade={"persist"} to save without 1st saving profile instance
	//       @ORM\OneToOne(targetEntity="Application\Entity\Profile", cascade={"persist"})
	//       need to add cascade={"remove"} to remove without 1st removing profile instance
	//       @ORM\OneToOne(targetEntity="Application\Entity\Profile", cascade={"remove"})
	//       or ... if you want to do both:
	//       @ORM\OneToOne(targetEntity="Application\Entity\Profile", cascade={"persist","remove"})        
	/**
     * @ANO\ComposedObject("Application\Entity\Profile")
     * @ORM\OneToOne(targetEntity="Application\Entity\Profile", cascade={"persist","remove"})
     */
	protected $profile;
	
	/**
     * 1 customer:many purchases
	 * @var \Doctrine\Common\Collections\Collection
     * @ANO\ComposedObject("Application\Entity\Purchases")
     * @ORM\OneToMany(targetEntity="Application\Entity\Purchases", 
     *                mappedBy="customer", cascade={"persist","remove"})
     * @ORM\OrderBy({"date" = "DESC"})
     */
	protected $purchases;
    
    /**
     * many customers:many products
     * NOTE: you don't need to specify "mappedBy" as both sides could be considering "owning"
     * @ANO\Exclude
     * @ORM\ManyToMany(targetEntity="Application\Entity\Products", mappedBy="customers")
     * if JoinTable is not specified, Doctrine creates one for you
     * @ORM\JoinTable(name="products_customers",
     *      joinColumns={@ORM\JoinColumn(name="customers_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="products_id", referencedColumnName="id")}
     *      )    
     */
	protected $products;
    
	/**
     * Initializes purchases as an array
     * Initializes products as an array
	 */
	public function __construct() 
	{
		$this->purchases = new ArrayCollection();
		$this->products  = new ArrayCollection();
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
     * @return the $balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param field_type $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param field_type $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param field_type $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param field_type $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return the $securityQuestion
     */
    public function getSecurityQuestion()
    {
        return $this->securityQuestion;
    }

    /**
     * @param field_type $securityQuestion
     */
    public function setSecurityQuestion($securityQuestion)
    {
        $this->securityQuestion = $securityQuestion;
    }

    /**
     * @return the $confirmCode
     */
    public function getConfirmCode()
    {
        return $this->confirmCode;
    }

    /**
     * @param field_type $confirmCode
     */
    public function setConfirmCode($confirmCode)
    {
        $this->confirmCode = $confirmCode;
    }

    /**
     * @return the $profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param field_type $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return the $purchases
     */
    public function getPurchases()
    {
        return $this->purchases;
    }

    /**
     * Adds multiple purchases
     */
    public function setPurchases($purchase)
    {
        $this->purchases[] = $purchase;
    }
    
    /**
     * Adds one purchases
     */
    public function setOnePurchase($purchase, $index)
    {
        $this->purchases[$index] = $purchase;
    }
    
    /**
     * @return the $products
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Adds multiple products
     */
    public function setProducts($product)
    {
        $this->products[] = $product;
    }
	
 }
