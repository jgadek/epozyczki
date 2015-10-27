<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DataBundle\Entity\Credit;

/**
 * Loan
 *
 * @ORM\Table(name="loan")
 * @ORM\Entity(repositoryClass="DataBundle\Entity\LoanRepository")
 */
class Loan
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
     * @var Loan
     * 
     * @ORM\OneToOne(targetEntity="Credit", mappedBy="loan")
     * @ORM\JoinColumn(name="credit_id", referencedColumnName="id")
     */
    protected $credit;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

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

    /* STATUSY */

    CONST STATUS_IN_PROGRESS = 101;
    CONST STATUS_IS_PROBLEM = 201;
    CONST STATUS_FINISHED = 301;


    /* LIMITY */
    CONST DEFAULT_LIMIT_LOAN_ADMIN_LIST = 25;

    protected static $arrStatusLabel = array(
        self::STATUS_IN_PROGRESS => 'Pożyczka w trakcie spłaty',
        self::STATUS_IS_PROBLEM => 'Problem ze spłatą pożyczki',
        self::STATUS_FINISHED => 'Pożyczka spłacona',
    );

    public function getStatusLabel()
    {
        return self::$arrStatusLabel[$this->getStatus()];
    }

    public static function GetStatuses()
    {
        return self::$arrStatusLabel;
    }

    public function isStatusToChangeByAdmin()
    {
        $arrStatuses = array(
            self::STATUS_IN_PROGRESS,
            self::STATUS_IS_PROBLEM,
        );
        return in_array($this->getStatus(), $arrStatuses, true);
    }

    public function getListStatusesForActive()
    {
        if ($this->getStatus() === self::STATUS_IN_PROGRESS) {
            return \Acme\Utils\HtmlCreator::CreateSelect(array(
                        '_vns_' => 'Zmień status',
                        self::STATUS_IS_PROBLEM => self::$arrStatusLabel[self::STATUS_IS_PROBLEM],
                        self::STATUS_FINISHED => self::$arrStatusLabel[self::STATUS_FINISHED],
                            ), 'loan_statuses', '', $this->getStatus());
        }

        if ($this->getStatus() === self::STATUS_IS_PROBLEM) {
            return \Acme\Utils\HtmlCreator::CreateSelect(array(
                        '_vns_' => 'Zmień status',
                        self::STATUS_IN_PROGRESS => self::$arrStatusLabel[self::STATUS_IN_PROGRESS],
                        self::STATUS_FINISHED => self::$arrStatusLabel[self::STATUS_FINISHED],
                            ), 'loan_statuses', '', $this->getStatus());
        }

        if ($this->getStatus() === self::STATUS_FINISHED) {
            return \Acme\Utils\HtmlCreator::CreateSelect(array(
                        '_vns_' => 'Zmień status',
                        self::STATUS_IN_PROGRESS => self::$arrStatusLabel[self::STATUS_IN_PROGRESS],
                        self::STATUS_IS_PROBLEM => self::$arrStatusLabel[self::STATUS_IS_PROBLEM],
                            ), 'loan_statuses', '', $this->getStatus());
        }

        return $this->getStatusLabel();
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
        $this->status = self::STATUS_IN_PROGRESS;
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
     * Set credit
     *
     * @param Credit
     * @return Loan
     */
    public function setCredit(Credit $credit)
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

    /**
     * Set status
     *
     * @param integer $status
     * @return Loan
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Loan
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
     * @return Loan
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

}
