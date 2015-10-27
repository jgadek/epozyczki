<?php

namespace App\FrontendBundle\Utils\Form\Credit;

use App\FrontendBundle\Utils\Form\Credit\CreditForm;

class FirstStepCreditForm extends CreditForm
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('intCreditAmount', 'hidden');
        $builder->add('intRepaymentTime', 'hidden');
        
        $this->setDefault($builder);
    }
    
    public function setDefault(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        $builder->get('intCreditAmount')->setData($this->getCreditCreator()->getIntCreditAmount());
        $builder->get('intRepaymentTime')->setData($this->getCreditCreator()->getIntRepaymentTime());
    }
    
    public function save($arrValues)
    {
        $objCreditCreator = $this->getCreditCreator();
        $objCreditCreator->setIntCreditAmount($arrValues['intCreditAmount']);
        $objCreditCreator->setIntRepaymentTime($arrValues['intRepaymentTime']);
    }
}
