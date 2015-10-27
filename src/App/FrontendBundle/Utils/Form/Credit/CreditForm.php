<?php

namespace App\FrontendBundle\Utils\Form\Credit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\GuardBundle\Entity\GuardUser;
use App\FrontendBundle\Utils\Session\CreditCreator;

class CreditForm extends AbstractType
{

    private $objUser = null;
    private $objCreditCreator = null;
    

    public function __construct(CreditCreator $objCreditCreator, GuardUser $objUser = null)
    {
        $this->objCreditCreator = $objCreditCreator;
        $this->objUser = $objUser;
    }
    
    /**
     * @return CreditCreator
     */
    public function getCreditCreator()
    {
        return $this->objCreditCreator;
    }

    /**
     * @return GuardUser
     */
    public function getUser()
    {
        return $this->objUser;
    }
    
    /**
     * @param \App\GuardBundle\Entity\GuardUser $objUser
     */
    public function setUser(GuardUser $objUser)
    {
        $this->objUser = $objUser;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'credit_form';
    }

}
