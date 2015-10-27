<?php

namespace App\GuardBundle\Entity;

use App\GuardBundle\Entity\GuardGroup;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use App\GuardBundle\Entity\GuardUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use DataBundle\Entity\Message;

/**
 * GuardUser
 *
 * @ORM\Entity(repositoryClass="App\GuardBundle\Entity\GuardUserRepository")
 * @ORM\Table(name="guard_user")
 * @Serializer\ExclusionPolicy("ALL")
 */
class GuardUser extends BaseUser
{

    const DEFAULT_LIMIT = 10;
    const DEFAULT_LIMIT_ADMIN_LIST = 25;

    /* UDZIELAJĄCY POŻYCZKI */
    CONST ROLE_LENDER = 'ROLE_LENDER';

    /* POŻYCZKOBIORCA */
    CONST ROLE_BORROWER = 'ROLE_BORROWER';
    CONST ROLE_ADMIN = 'ROLE_ADMIN';
    CONST ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\GuardBundle\Entity\GuardGroup")
     * @ORM\JoinTable(name="guard_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\Column(name="type_of_person", type="integer", nullable=true)
     */
    protected $typeOfPerson;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="second_name", type="string", length=255, nullable=true)
     */
    protected $secondName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="pesel", type="string", length=255, nullable=true)
     */
    protected $pesel;

    /**
     * @var string
     *
     * @ORM\Column(name="edg", type="string", length=255, nullable=true)
     */
    protected $edg;

    /**
     * @var string
     *
     * @ORM\Column(name="id_number", type="string", length=255, nullable=true)
     */
    protected $idNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * @var string
     *
     * @ORM\Column(name="post_code", type="string", length=255, nullable=true)
     */
    protected $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    protected $facebook;

    /**
     * @ORM\OneToMany(targetEntity="DataBundle\Entity\Credit", mappedBy="guardUser")
     */
    protected $credits;

    /**
     * @ORM\OneToMany(targetEntity="DataBundle\Entity\Credit", mappedBy="lender")
     */
    protected $lenderCredits;

    /**
     * @ORM\Column(name="lender_amount_from", type="integer", nullable=true)
     */
    protected $lenderAmountFrom;

    /**
     * @ORM\Column(name="lender_amount_to", type="integer", nullable=true)
     */
    protected $lenderAmountTo;

    /**
     * @ORM\Column(name="lender_replayment_time_from", type="integer", nullable=true)
     */
    protected $lenderReplaymentTimeForm;

    /**
     * @ORM\Column(name="lender_replayment_time_to", type="integer", nullable=true)
     */
    protected $lenderReplaymentTimeTo;

    /**
     * @ORM\Column(name="lender_mortgage", type="boolean", nullable=true)
     */
    protected $lenderMortgage;

    /**
     * @ORM\Column(name="lender_bill_of_exchange", type="boolean", nullable=true)
     */
    protected $lenderBillOfExchange;

    /**
     * @ORM\Column(name="lender_credit_insurance", type="boolean", nullable=true)
     */
    protected $lenderCreditInsurance;

    /**
     * @ORM\Column(name="lender_guarantor", type="boolean", nullable=true)
     */
    protected $lenderGuarantor;

    /**
     * @ORM\Column(name="lender_777", type="boolean", nullable=true)
     */
    protected $lender777;

    /**
     * @ORM\Column(name="lender_take_ownership", type="boolean", nullable=true)
     */
    protected $lenderTakeOwnership;

    /**
     * @ORM\Column(name="name_of_corporation", type="string", length=255, nullable=true)
     */
    protected $nameOfCorporation;

    /**
     * @ORM\Column(name="representative", type="string", length=255, nullable=true)
     */
    protected $representative;

    /**
     * @ORM\Column(name="nip", type="string", length=255, nullable=true)
     */
    protected $nip;

    /**
     * @ORM\Column(name="regon", type="string", length=255, nullable=true)
     */
    protected $regon;

    /**
     * @ORM\Column(name="lender_email_credits", type="boolean", nullable=true, options={"default" = "1"})
     */
    protected $lenderEmailCredits;

    /**
     * @ORM\OneToMany(targetEntity="\DataBundle\Entity\Offer", mappedBy="lender")
     */
    private $offers;

    /**
     * @ORM\OneToMany(targetEntity="\DataBundle\Entity\Message", mappedBy="guardUser")
     */
    private $messages;
    
    /**
     * @ORM\Column(name="is_new", type="boolean", nullable=true)
     */
    private $isNew;
    
    CONST ENTITY_PATH = 'AppGuardBundle:GuardUser';

    private $arrErrors = array();

    public function __construct()
    {
        parent::__construct();
        $this->credits = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->lenderCredits = new ArrayCollection();
        $this->offers = new ArrayCollection();
        $this->isNew = true;
    }

    public function getTypeOfUser()
    {
        if ($this->hasRole(self::ROLE_BORROWER)) {
            return 'Pożyczkobiorca';
        }

        if ($this->hasRole(self::ROLE_LENDER)) {
            return 'Pożyczkodawca';
        }

        if ($this->hasRole(self::ROLE_ADMIN) || $this->hasRole(self::ROLE_SUPER_ADMIN)) {
            return 'Administrator';
        }
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

    public function getTypeOfPerson()
    {
        return $this->typeOfPerson;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getSecondName()
    {
        return $this->secondName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getPesel()
    {
        return $this->pesel;
    }

    public function getEdg()
    {
        return $this->edg;
    }

    public function getIdNumber()
    {
        return $this->idNumber;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPostCode()
    {
        return $this->postCode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getFacebook()
    {
        return $this->facebook;
    }

    public function getCredits()
    {
        return $this->credits;
    }

    public function getLenderCredits()
    {
        return $this->lenderCredits;
    }

    public function getLenderAmountFrom()
    {
        return $this->lenderAmountFrom;
    }

    public function getLenderAmountTo()
    {
        return $this->lenderAmountTo;
    }

    public function getLenderReplaymentTimeForm()
    {
        return $this->lenderReplaymentTimeForm;
    }

    public function getLenderReplaymentTimeTo()
    {
        return $this->lenderReplaymentTimeTo;
    }

    public function getLenderMortgage()
    {
        return $this->lenderMortgage;
    }

    public function getLenderBillOfExchange()
    {
        return $this->lenderBillOfExchange;
    }

    public function getLenderCreditInsurance()
    {
        return $this->lenderCreditInsurance;
    }

    public function getLenderGuarantor()
    {
        return $this->lenderGuarantor;
    }

    public function getLender777()
    {
        return $this->lender777;
    }

    public function getLenderTakeOwnership()
    {
        return $this->lenderTakeOwnership;
    }

    public function getNameOfCorporation()
    {
        return $this->nameOfCorporation;
    }

    public function getRepresentative()
    {
        return $this->representative;
    }

    public function getNip()
    {
        return $this->nip;
    }

    public function getRegon()
    {
        return $this->regon;
    }

    public function getLenderEmailCredits()
    {
        return $this->lenderEmailCredits;
    }

    public function addCredit(\DataBundle\Entity\Credit $credits)
    {
        $this->credits->add($credits);
    }

    public function addLenderCredit(\DataBundle\Entity\Credit $credits)
    {
        $this->lenderCredits->add($credits);
    }

    public function setTypeOfPerson($typeOfPerson)
    {
        $this->typeOfPerson = $typeOfPerson;
        return $this;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;
        return $this;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setPesel($pesel)
    {
        $this->pesel = $pesel;
        return $this;
    }

    public function setEdg($edg)
    {
        $this->edg = $edg;
        return $this;
    }

    public function setIdNumber($idNumber)
    {
        $this->idNumber = $idNumber;
        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
        return $this;
    }

    public function setLenderAmountFrom($lenderAmountFrom)
    {
        $this->lenderAmountFrom = $lenderAmountFrom;
        return $this;
    }

    public function setLenderAmountTo($lenderAmountTo)
    {
        $this->lenderAmountTo = $lenderAmountTo;
        return $this;
    }

    public function setLenderReplaymentTimeForm($lenderReplaymentTimeForm)
    {
        $this->lenderReplaymentTimeForm = $lenderReplaymentTimeForm;
        return $this;
    }

    public function setLenderReplaymentTimeTo($lenderReplaymentTimeTo)
    {
        $this->lenderReplaymentTimeTo = $lenderReplaymentTimeTo;
        return $this;
    }

    public function setLenderMortgage($lenderMortgage)
    {
        $this->lenderMortgage = $lenderMortgage;
        return $this;
    }

    public function setLenderBillOfExchange($lenderBillOfExchange)
    {
        $this->lenderBillOfExchange = $lenderBillOfExchange;
        return $this;
    }

    public function setLenderCreditInsurance($lenderCreditInsurance)
    {
        $this->lenderCreditInsurance = $lenderCreditInsurance;
        return $this;
    }

    public function setLenderGuarantor($lenderGuarantor)
    {
        $this->lenderGuarantor = $lenderGuarantor;
        return $this;
    }

    public function setLender777($lender777)
    {
        $this->lender777 = $lender777;
        return $this;
    }

    public function setLenderTakeOwnership($lenderTakeOwnership)
    {
        $this->lenderTakeOwnership = $lenderTakeOwnership;
        return $this;
    }

    public function setNameOfCorporation($nameOfCorporation)
    {
        $this->nameOfCorporation = $nameOfCorporation;
        return $this;
    }

    public function setRepresentative($representative)
    {
        $this->representative = $representative;
        return $this;
    }

    public function setNip($nip)
    {
        $this->nip = $nip;
        return $this;
    }

    public function setRegon($regon)
    {
        $this->regon = $regon;
        return $this;
    }

    public function setLenderEmailCredits($lenderEmailCredits)
    {
        $this->lenderEmailCredits = $lenderEmailCredits;
        return $this;
    }

    public function removeCredit(\DataBundle\Entity\Credit $credits)
    {
        $this->credits->removeElement($credits);
    }

    public function removeLenderCredit(\DataBundle\Entity\Credit $credits)
    {
        $this->lenderCredits->removeElement($credits);
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

    public function isValid(\Doctrine\ORM\EntityManager $em)
    {
        $unique = $em
                ->createQueryBuilder()
                ->select('count(gu)')
                ->from(self::ENTITY_PATH, 'gu')
                ->where('gu.username = :username')
                ->orWhere('gu.email = :email')
                ->setParameter('username', $this->getUsername())
                ->setParameter('email', $this->getEmail())
                ->getQuery()
                ->getOneOrNullResult(\Doctrine\ORM\AbstractQuery::HYDRATE_SINGLE_SCALAR);

        if ((int) $unique !== 0) {
            $this->addError('Username or email is not unique');
        }
        if (!\Acme\Utils\Validator::email($this->getEmail())) {
            $this->addError('Email address is not valid');
        }
        if ($this->hasErrors()) {
            return false;
        }
        return true;
    }

    public function addError($error)
    {
        $this->arrErrors[] = $error;
    }

    public function hasErrors()
    {
        return count($this->arrErrors) ? true : false;
    }

    public function getErrors()
    {
        return $this->arrErrors;
    }

    public function remove()
    {
        
    }

    public function clearLender()
    {
        $this
                ->setFirstName(null)
                ->setSecondName(null)
                ->setLastName(null)
                ->setPesel(null)
                ->setIdNumber(null)
                ->setAddress(null)
                ->setPostCode(null)
                ->setCity(null)
                ->setPhone(null)
                ->setNameOfCorporation(null)
                ->setRepresentative(null)
                ->setEdg(null)
                ->setNip(null)
                ->setRegon(null)
                ->setAddress(null)
        ;
    }

}
