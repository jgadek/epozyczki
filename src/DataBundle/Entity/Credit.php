<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DataBundle\Entity\Offer;
use DataBundle\Entity\Loan;
use DataBundle\Entity\Message;

/**
 * Credit
 *
 * @ORM\Table(name="credit")
 * @ORM\Entity(repositoryClass="DataBundle\Entity\CreditRepository")
 */
class Credit
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
     * @ORM\ManyToOne(targetEntity="\App\GuardBundle\Entity\GuardUser", inversedBy="credits")
     * @ORM\JoinColumn(name="guard_user", referencedColumnName="id")
     */
    private $guardUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="credit_amount", type="integer")
     */
    private $creditAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="replayment_time", type="integer")
     */
    private $replaymentTime;

    /**
     * @var string
     *
     * @ORM\Column(name="purpose", type="string", length=255)
     */
    private $purpose;

    /**
     * @var string
     *
     * @ORM\Column(name="purpose_description", type="text")
     */
    private $purposeDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="replayment_method", type="integer")
     */
    private $replaymentMethod;

    /**
     * @var integer
     *
     * @ORM\Column(name="source_of_income", type="integer")
     */
    private $sourceOfIncome;

    /**
     * @var integer
     *
     * @ORM\Column(name="salary", type="integer")
     */
    private $salary;

    /**
     * @var integer
     *
     * @ORM\Column(name="marital_status", type="integer")
     */
    private $maritalStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="number_of_children", type="integer")
     */
    private $numberOfChildren;

    /**
     * @var string
     *
     * @ORM\Column(name="type_of_security", type="string", length=255)
     */
    private $typeOfSecurity;

    /**
     * @var string
     *
     * @ORM\Column(name="type_of_security_description", type="text")
     */
    private $typeOfSecurityDescription;

    /**
     * @ORM\OneToMany(targetEntity="DataBundle\Entity\CreditFile", mappedBy="credit")
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="\DataBundle\Entity\Offer", mappedBy="credit")
     */
    private $offers;

    /**
     * @ORM\ManyToOne(targetEntity="\App\GuardBundle\Entity\GuardUser", inversedBy="lenderCredits")
     * @ORM\JoinColumn(name="lender", referencedColumnName="id")
     */
    private $lender;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $references;

    /**
     * @var loan
     *
     * @ORM\OneToOne(targetEntity="Loan", inversedBy="credit")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id")
     */
    protected $loan;

    /**
     * @ORM\OneToMany(targetEntity="\DataBundle\Entity\Message", mappedBy="credit")
     */
    private $messages;

    /* STATUSY */

    CONST STATUS_NEW = 101;
    CONST STATUS_ADMIN_VERIFICATION = 102;
    CONST STATUS_ADMIN_ACCEPTED = 201;
    CONST STATUS_BORROWER_ACCEPTED = 202;
    CONST STATUS_SECOND_ADMIN_ACCEPTED = 203;
    CONST STATUS_ADMIN_REJECTED = 301;
    CONST STATUS_BORROWER_REJECTED = 302;
    CONST STATUS_SECOND_ADMIN_REJECTED = 303;
    CONST STATUS_FINISHED = 401;


    /* LIMITY */
    CONST DEFAULT_LIMIT_CREDITS_LIST = 5;
    CONST DEFAULT_LIMIT_LENDER_DASHBOARD = 25;
    CONST DEFAULT_LIMIT_BORROWER = 25;
    CONST DEFAULT_LIMIT_ADMIN_LIST = 25;

    protected static $arrStatusLabel = array(
        self::STATUS_NEW => 'Do aktywacji',
        self::STATUS_ADMIN_VERIFICATION => 'Weryfikacja przez administratora e-pozyczki.pl',
        self::STATUS_ADMIN_ACCEPTED => 'Wniosek zaakceptowany przez administratora',
        self::STATUS_BORROWER_ACCEPTED => 'Oferta zaakceptowana przez pożyczkobiorce',
        self::STATUS_SECOND_ADMIN_ACCEPTED => 'Oferta zaakceptowana - pożyczka udzielona',
        self::STATUS_ADMIN_REJECTED => 'Odrzucona przez administratora',
        self::STATUS_BORROWER_REJECTED => 'Anulowana przez pożyczkobiorce',
        self::STATUS_SECOND_ADMIN_REJECTED => 'Oferta anulowana przez administratora',
        self::STATUS_FINISHED => 'Zakończony',
    );

    public function getStepNew()
    {
        return true;
    }

    public function getStepVerificationAdministator()
    {
        return $this->getStatus() > self::STATUS_NEW;
    }

    public function getStepPreviousWaitToOffer()
    {
        return $this->getStatus() <= self::STATUS_ADMIN_VERIFICATION;
    }

    public function getStepWaitToOffer()
    {
        return $this->getStatus() == self::STATUS_ADMIN_ACCEPTED;
    }

    public function getStepAfterWaitToOffer()
    {
        return $this->getStatus() > self::STATUS_ADMIN_ACCEPTED;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
        $this->status = self::STATUS_NEW;
        $this->files = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function isStatusToChangeByAdmin()
    {
        $arrStatuses = array(
            self::STATUS_ADMIN_VERIFICATION,
            self::STATUS_ADMIN_REJECTED,
            self::STATUS_BORROWER_ACCEPTED,
        );
        return in_array($this->getStatus(), $arrStatuses, true);
    }

    public function getListStatusesForActive()
    {
        if ($this->getStatus() === self::STATUS_ADMIN_REJECTED) {
            return \Acme\Utils\HtmlCreator::CreateSelect(array(
                        '_vns_' => 'Zmień status',
                        self::STATUS_ADMIN_VERIFICATION => self::$arrStatusLabel[self::STATUS_ADMIN_VERIFICATION],
                        self::STATUS_ADMIN_ACCEPTED => self::$arrStatusLabel[self::STATUS_ADMIN_ACCEPTED],
                            ), 'credit_statuses', '', $this->getStatus());
        }

        if ($this->getStatus() === self::STATUS_ADMIN_VERIFICATION) {
            return \Acme\Utils\HtmlCreator::CreateSelect(array(
                        '_vns_' => 'Zmień status',
                        self::STATUS_ADMIN_ACCEPTED => self::$arrStatusLabel[self::STATUS_ADMIN_ACCEPTED],
                        self::STATUS_ADMIN_REJECTED => self::$arrStatusLabel[self::STATUS_ADMIN_REJECTED],
                            ), 'credit_statuses', '', $this->getStatus());
        }

        if ($this->getStatus() === self::STATUS_BORROWER_ACCEPTED) {
            return \Acme\Utils\HtmlCreator::CreateSelect(array(
                        '_vns_' => 'Zmień status',
                        self::STATUS_SECOND_ADMIN_ACCEPTED => self::$arrStatusLabel[self::STATUS_SECOND_ADMIN_ACCEPTED],
                        self::STATUS_SECOND_ADMIN_REJECTED => self::$arrStatusLabel[self::STATUS_SECOND_ADMIN_REJECTED],
                            ), 'credit_statuses', '', $this->getStatus());
        }

        return $this->getStatusLabel();
    }

    public function getStatusLabel()
    {
        return self::$arrStatusLabel[$this->getStatus()];
    }

    public static function GetStatuses()
    {
        return self::$arrStatusLabel;
    }

    public static function GetStatusesHidden()
    {
        return array(
            self::STATUS_BORROWER_REJECTED,
            self::STATUS_SECOND_ADMIN_REJECTED
        );
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
     * @return Credit
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
     * @return Credit
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
     * @return Credit
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
     * Set guardUser
     *
     * @param \App\GuardBundle\Entity\GuardUser $guardUser
     * @return Credit
     */
    public function setGuardUser($guardUser)
    {
        $this->guardUser = $guardUser;

        return $this;
    }

    /**
     * Get guardUser
     *
     * @return \App\GuardBundle\Entity\GuardUser 
     */
    public function getGuardUser()
    {
        return $this->guardUser;
    }

    /**
     * Set lender
     *
     * @param \App\GuardBundle\Entity\GuardUser $lender
     * @return Credit
     */
    public function setLender($lender)
    {
        $this->lender = $lender;

        return $this;
    }

    /**
     * Get lender
     *
     * @return \App\GuardBundle\Entity\GuardUser 
     */
    public function getLender()
    {
        return $this->lender;
    }

    /**
     * Set creditAmount
     *
     * @param integer $creditAmount
     * @return Credit
     */
    public function setCreditAmount($creditAmount)
    {
        $this->creditAmount = $creditAmount;

        return $this;
    }

    /**
     * Get creditAmount
     *
     * @return integer 
     */
    public function getCreditAmount()
    {
        return $this->creditAmount;
    }

    /**
     * Get creditAmount to list
     *
     * @return string 
     */
    public function creditAmountLabel($separator = '.')
    {
        if ($this->getCreditAmount() > 1000000) {
            return preg_replace('/(\d+)(\d{3})(\d{3})/', '\\1' . $separator . '\\2' . $separator . '\\3', $this->creditAmount);
        }
        return preg_replace('/(\d+)(\d{3})/', '\\1' . $separator . '\\2', $this->creditAmount);
    }

    /**
     * Set replaymentTime
     *
     * @param integer $replaymentTime
     * @return Credit
     */
    public function setReplaymentTime($replaymentTime)
    {
        $this->replaymentTime = $replaymentTime;

        return $this;
    }

    /**
     * Get replaymentTime
     *
     * @return integer 
     */
    public function getReplaymentTime()
    {
        return $this->replaymentTime;
    }

    /**
     * Set purpose
     *
     * @param string $purpose
     * @return Credit
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;

        return $this;
    }

    /**
     * Get purpose
     *
     * @return string 
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * Set purposeDescription
     *
     * @param string $purposeDescription
     * @return Credit
     */
    public function setPurposeDescription($purposeDescription)
    {
        $this->purposeDescription = $purposeDescription;

        return $this;
    }

    /**
     * Get purposeDescription
     *
     * @return string 
     */
    public function getPurposeDescription()
    {
        return $this->purposeDescription;
    }

    /**
     * Set replaymentMethod
     *
     * @param integer $replaymentMethod
     * @return Credit
     */
    public function setReplaymentMethod($replaymentMethod)
    {
        $this->replaymentMethod = $replaymentMethod;

        return $this;
    }

    /**
     * Get replaymentMethod
     *
     * @return integer 
     */
    public function getReplaymentMethod()
    {
        return $this->replaymentMethod;
    }

    /**
     * Get replaymentMethodLabel
     *
     * @return string 
     */
    public function getReplaymentMethodLabel()
    {
        return \App\FrontendBundle\Utils\Session\CreditCreator::GetReplaymentMethodToString($this->replaymentMethod);
    }

    /**
     * Set sourceOfIncome
     *
     * @param integer $sourceOfIncome
     * @return Credit
     */
    public function setSourceOfIncome($sourceOfIncome)
    {
        $this->sourceOfIncome = $sourceOfIncome;

        return $this;
    }

    /**
     * Get sourceOfIncome
     *
     * @return integer 
     */
    public function getSourceOfIncome()
    {
        return $this->sourceOfIncome;
    }

    public function getSourceOfIncomeLabel()
    {
        return \App\FrontendBundle\Utils\Session\CreditCreator::GetSourceOfIncomeToString($this->sourceOfIncome);
    }

    /**
     * Set salary
     *
     * @param integer $salary
     * @return Credit
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return integer 
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Get salary
     *
     * @return integer 
     */
    public function getSalaryLabel($separator = '.')
    {
        if ($this->getSalary() > 1000000) {
            return preg_replace('/(\d+)(\d{3})(\d{3})/', '\\1' . $separator . '\\2' . $separator . '\\3', $this->getSalary());
        }
        return preg_replace('/(\d+)(\d{3})/', '\\1' . $separator . '\\2', $this->getSalary());
    }

    /**
     * Set maritalStatus
     *
     * @param integer $maritalStatus
     * @return Credit
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    /**
     * Get maritalStatus
     *
     * @return integer 
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * Get maritalStatus
     *
     * @return string 
     */
    public function getMaritalStatusLabel()
    {
        return \App\FrontendBundle\Utils\Session\CreditCreator::GetMaritalStatuseLabel($this->maritalStatus);
    }

    /**
     * Set numberOfChildren
     *
     * @param integer $numberOfChildren
     * @return Credit
     */
    public function setNumberOfChildren($numberOfChildren)
    {
        $this->numberOfChildren = $numberOfChildren;

        return $this;
    }

    /**
     * Get numberOfChildren
     *
     * @return integer 
     */
    public function getNumberOfChildren()
    {
        return $this->numberOfChildren;
    }

    /**
     * Get numberOfChildren
     *
     * @return string 
     */
    public function getNumberOfChildrenLabel()
    {
        return \App\FrontendBundle\Utils\Session\CreditCreator::GetNumbersOfChildrenLabel($this->numberOfChildren);
    }

    /**
     * Set typeOfSecurity
     *
     * @param string $typeOfSecurity
     * @return Credit
     */
    public function setTypeOfSecurity($typeOfSecurity)
    {
        $this->typeOfSecurity = $typeOfSecurity;

        return $this;
    }

    /**
     * Get typeOfSecurity
     *
     * @return string 
     */
    public function getTypeOfSecurity()
    {
        return $this->typeOfSecurity;
    }

    /**
     * Set typeOfSecurityDescription
     *
     * @param string $typeOfSecurityDescription
     * @return Credit
     */
    public function setTypeOfSecurityDescription($typeOfSecurityDescription)
    {
        $this->typeOfSecurityDescription = $typeOfSecurityDescription;

        return $this;
    }

    /**
     * Get typeOfSecurityDescription
     *
     * @return string 
     */
    public function getTypeOfSecurityDescription()
    {
        return $this->typeOfSecurityDescription;
    }

    /**
     * Set files
     *
     * @param \stdClass $files
     * @return Credit
     */
    public function addFile(CreditFile $file)
    {
        $this->files->add($file);
        return $this;
    }

    /**
     * Get files
     *
     * @return ArrayCollection 
     */
    public function getFiles()
    {
        return $this->files;
    }

    public static function GetArrayFilesImg()
    {
        
    }

    public function getFilesToDownload()
    {
        return $this->getFiles()->filter(function(CreditFile $objFile) {
                    return !preg_match('/^image(.*)/', $objFile->getMime());
                });
    }

    public function getImages()
    {
        return $this->getFiles()->filter(function(CreditFile $objFile) {
                    return preg_match('/^image(.*)/', $objFile->getMime());
                });
    }

    public function getReferences()
    {
        return $this->references;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getOffers()
    {
        return $this->offers;
    }

    public function addOffer(Offer $offers)
    {
        $this->getOffers()->add($offers);
    }

    public function removeOffer(Offer $offers)
    {
        $this->getOffers()->removeElement($offers);
    }

    public function hasOfferFromUser(\App\GuardBundle\Entity\GuardUser $objUser)
    {
        return $this->getOffers()->filter(function(Offer $offer) use ($objUser) {
                    return $objUser === $offer->getLender();
                })->count() === 0 ? false : true;
    }

    /**
     * Set loan
     *
     * @param Loan
     * @return Credit
     */
    public function setLoan(Loan $loan)
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get loan
     *
     * @return Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }

    /**
     * 
     * @return ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    public function addMessage(Message $message)
    {
        $this->getMessages()->add($message);
    }

    public function removeMessage(Message $message)
    {
        $this->getMessages()->removeElement($message);
    }

    public function save(\Doctrine\ORM\EntityManager $em)
    {
        while (true) {
            $references = \Acme\Utils\Generator::GetIdNumbers();
            if (!$em->getRepository('DataBundle:Credit')->findOneByReferences($references) instanceof Credit) {
                $this->references = $references;
                break;
            }
        }
    }

}
