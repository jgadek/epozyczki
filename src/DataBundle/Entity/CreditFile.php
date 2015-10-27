<?php

namespace DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CreditFile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DataBundle\Entity\CreditFileRepository")
 */
class CreditFile
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
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="mime", type="string", length=255)
     */
    private $mime;

    /**
     * @ORM\ManyToOne(targetEntity="DataBundle\Entity\Credit", inversedBy="files")
     * @ORM\JoinColumn(name="credit", referencedColumnName="id")
     */
    private $credit;

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
     * Set filename
     *
     * @param string $filename
     * @return CreditFile
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set mime
     *
     * @param string $mime
     * @return CreditFile
     */
    public function setMime($mime)
    {
        $this->mime = $mime;

        return $this;
    }

    /**
     * Get mime
     *
     * @return string 
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Set credit
     *
     * @param Credit
     * @return CreditFile
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

    public function save($base64)
    {
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }
        if (!is_dir('uploads/credit')) {
            mkdir('uploads/credit');
        }
        $path = 'uploads/credit/' . $this->getCredit()->getId();
        if (!is_dir($path)) {
            mkdir($path);
        }
        $ifp = fopen($path . '/' . $this->getFilename(), "wb");
        fwrite($ifp, base64_decode($base64));
        fclose($ifp);
    }
    
    public function getClassname()
    {
        return preg_replace('/.*\//', '', $this->getMime());
    }
    
    public function getPath()
    {
        return '/uploads/credit/'.$this->getCredit()->getId().'/'.$this->getFilename();
    }

}
