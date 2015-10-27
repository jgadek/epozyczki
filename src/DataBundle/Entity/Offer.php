<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DataBundle\Entity\Credit;
use App\GuardBundle\Entity\GuardUser;

/**
 * Offer
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DataBundle\Entity\OfferRepository")
 */
class Offer
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="\App\GuardBundle\Entity\GuardUser", inversedBy="offers")
     * @ORM\JoinColumn(name="lender", referencedColumnName="id")
     */
    private $lender;

    /**
     * @ORM\ManyToOne(targetEntity="\DataBundle\Entity\Credit", inversedBy="offers")
     * @ORM\JoinColumn(name="credit", referencedColumnName="id")
     */
    private $credit;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $references;

    /**
     * @var integer
     *
     * @ORM\Column(name="credit_amount", type="integer", nullable=true)
     */
    private $amountOffered;

    /**
     * @var integer
     *
     * @ORM\Column(name="interest", type="integer", nullable=true)
     */
    private $interest;

    /**
     * @var integer
     *
     * @ORM\Column(name="replayment_time", type="integer", nullable=true)
     */
    private $replaymentTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="replayment_method", type="integer", nullable=true)
     */
    private $replaymentMethod;

    /**
     * @var string
     * 
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="commission", type="integer", nullable=true)
     */
    private $commission;

    /**
     * @var integer
     *
     * @ORM\Column(name="security_price", type="integer", nullable=true)
     */
    private $securityPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="insurance_transactions", type="integer", nullable=true)
     */
    private $insuranceTransactions;

    /**
     * @var integer
     *
     * @ORM\Column(name="notary_costs", type="integer", nullable=true)
     */
    private $notaryCosts;

    /**
     * @var string
     *
     * @ORM\Column(name="type_of_security", type="string", length=255, nullable=true)
     */
    private $typeOfSecurity;

    /**
     * @var string
     *
     * @ORM\Column(name="expired_at", type="datetime", nullable=true)
     */
    private $expiredAt;

    CONST DEFAULT_LIMIT_OFFER_ADMIN_LIST = 25;

    /**
     * statusy
     */
    CONST STATUS_NEW = 101;
    CONST STATUS_ACCEPTED = 201;
    CONST STATUS_REJECTED = 301;
    CONST STATUS_EXPIRED = 401;
    CONST STATUS_FINISHED = 402;

    protected static $arrStatusesLabel = array(
        self::STATUS_NEW => 'Nowa oferta',
        self::STATUS_ACCEPTED => 'Oferta zaakceptowana przez pożyczkoodbiocę',
        self::STATUS_REJECTED => 'Oferta odrzucona przez pożyczkoodbiocę',
        self::STATUS_FINISHED => 'Zakończone',
    );

    public function getStatusLabel()
    {
        return self::$arrStatusesLabel[$this->getStatus()];
    }

    public static function GetStatuses()
    {
        return self::$arrStatusesLabel;
    }

    CONST DEFAULT_COMMISSION = 1;
    CONST DEFAULT_INSURANCE_TRANSACTION = 500;
    CONST DEFAULT_NOTARY_COSTS = 1000;
    CONST DEFAULT_SECURITY_PRICE = 300;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
        $this->status = self::STATUS_NEW;
        $this->commission = self::DEFAULT_COMMISSION;
        $this->insuranceTransactions = self::DEFAULT_INSURANCE_TRANSACTION;
        $this->notaryCosts = self::DEFAULT_NOTARY_COSTS;
        $this->securityPrice = self::DEFAULT_SECURITY_PRICE;
    }

    public function save(\Doctrine\ORM\EntityManager $em)
    {
        $referencesCredit = $this->getCredit()->getReferences();
        $lastOffer = $em->getRepository('DataBundle:Offer')->findOneBy(
                array('credit' => $this->getCredit()), array('id' => 'DESC')
        );
        if ($lastOffer instanceof Offer) {
            $arrId = explode('-', $lastOffer->getReferences());
            $this->references = $referencesCredit . '-' . (((int) $arrId[1]) + 1);
            return true;
        }
        $this->references = $referencesCredit . '-1';
        return true;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Offer
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Offer
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Offer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set lender
     *
     * @param GuardUser $lender
     * @return Offer
     */
    public function setLender($lender)
    {
        $this->lender = $lender;

        return $this;
    }

    /**
     * Get lender
     *
     * @return GuardUser 
     */
    public function getLender()
    {
        return $this->lender;
    }

    /**
     * Set credit
     *
     * @param Credit $credit
     * @return Offer
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit
     *
     * @return Credit 
     */
    public function getCredit()
    {
        return $this->credit;
    }

    public function getReferences()
    {
        return $this->references;
    }

    public function getAmountOffered()
    {
        return $this->amountOffered;
    }

    public function getAmountOfferedLabel($separator = '.')
    {
        return \Acme\Utils\Cleaner::GetPriceLabel($this->getAmountOffered(), $separator);
    }

    public function getInterest()
    {
        return $this->interest;
    }

    public function getReplaymentTime()
    {
        return $this->replaymentTime;
    }

    public function getReplaymentMethod()
    {
        return $this->replaymentMethod;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCommission()
    {
        return $this->commission;
    }

    public function getSecurityPrice()
    {
        return $this->securityPrice;
    }

    public function getInsuranceTransactions()
    {
        return $this->insuranceTransactions;
    }

    public function getNotaryCosts()
    {
        return $this->notaryCosts;
    }

    public function getSecurityPriceLabel($separator = '.')
    {
        return \Acme\Utils\Cleaner::GetPriceLabel($this->securityPrice, $separator);
    }

    public function getInsuranceTransactionsLabel($separator = '.')
    {
        return \Acme\Utils\Cleaner::GetPriceLabel($this->insuranceTransactions, $separator);
    }

    public function getNotaryCostsLabel($separator = '.')
    {
        return \Acme\Utils\Cleaner::GetPriceLabel($this->notaryCosts, $separator);
    }

    public function getTypeOfSecurity()
    {
        return $this->typeOfSecurity;
    }

    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setReferences($references)
    {
        $this->references = $references;
        return $this;
    }

    public function setAmountOffered($amountOffered)
    {
        $this->amountOffered = $amountOffered;
        return $this;
    }

    public function setInterest($interest)
    {
        $this->interest = $interest;
        return $this;
    }

    public function setReplaymentTime($replaymentTime)
    {
        $this->replaymentTime = $replaymentTime;
        return $this;
    }

    public function setReplaymentMethod($replaymentMethod)
    {
        $this->replaymentMethod = $replaymentMethod;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setCommission($commission)
    {
        $this->commission = $commission;
        return $this;
    }

    public function setSecurityPrice($securityPrice)
    {
        $this->securityPrice = $securityPrice;
        return $this;
    }

    public function setInsuranceTransactions($insuranceTransactions)
    {
        $this->insuranceTransactions = $insuranceTransactions;
        return $this;
    }

    public function setNotaryCosts($notaryCosts)
    {
        $this->notaryCosts = $notaryCosts;
        return $this;
    }

    public function setTypeOfSecurity($typeOfSecurity)
    {
        $this->typeOfSecurity = $typeOfSecurity;
        return $this;
    }

    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;
        return $this;
    }

}
