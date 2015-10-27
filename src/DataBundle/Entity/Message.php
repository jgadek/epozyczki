<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\GuardBundle\Entity\GuardUser;
use DataBundle\Entity\Credit;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="DataBundle\Entity\MessageRepository")
 */
class Message
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

    /**
     * @ORM\ManyToOne(targetEntity="\App\GuardBundle\Entity\GuardUser", inversedBy="messages")
     * @ORM\JoinColumn(name="guard_user", referencedColumnName="id")
     */
    private $guardUser;

    /**
     * @ORM\ManyToOne(targetEntity="\DataBundle\Entity\Credit", inversedBy="messages")
     * @ORM\JoinColumn(name="credit", referencedColumnName="id")
     */
    private $credit;

    /**
     * @var integer
     *
     * @ORM\Column(name="typ", type="integer")
     */
    private $typ;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="reply", type="text", nullable=true)
     */
    private $reply;

    CONST STATUS_SEND = 1;
    CONST STATUS_REPLY = 2;

    CONST TYP_DEFAULT = 1;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
        $this->status = self::STATUS_SEND;
        $this->typ = self::TYP_DEFAULT;
    }

    public function hasStatusSend()
    {
        return $this->getStatus() === self::STATUS_SEND;
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
     * Set status
     *
     * @param integer $status
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * Set guardUser
     *
     * @param GuardUser $guardUser
     * @return Message
     */
    public function setGuardUser($guardUser)
    {
        $this->guardUser = $guardUser;

        return $this;
    }

    /**
     * Get guardUser
     *
     * @return GuardUser 
     */
    public function getGuardUser()
    {
        return $this->guardUser;
    }

    /**
     * Set credit
     *
     * @param Credit $credit
     * @return Message
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

    /**
     * Set typ
     *
     * @param integer $typ
     * @return Message
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;

        return $this;
    }

    /**
     * Get typ
     *
     * @return integer 
     */
    public function getTyp()
    {
        return $this->typ;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setReply($reply)
    {
        $this->reply = $reply;
        
        return $this;
    }

    public function getReply()
    {
        return $this->reply;
    }

}
