<?php

namespace App\FrontendBundle\Utils\Form\Lender;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\GuardBundle\Entity\GuardUser;
use App\FrontendBundle\Utils\Session\LenderCreator;

class LenderForm extends AbstractType
{

    private $objUser = null;
    private $objLenderCreator = null;

    public function __construct(LenderCreator $objLenderCreator, GuardUser $objUser = null)
    {
        $this->objLenderCreator = $objLenderCreator;
        $this->objUser = $objUser;
    }
    
    /**
     * @return LenderCreator
     */
    public function getLenderCreator()
    {
        return $this->objLenderCreator;
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
        return 'lender_form';
    }

}
