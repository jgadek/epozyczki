<?php

namespace App\FrontendBundle\Utils\Form\Lender;

use App\FrontendBundle\Utils\Form\Lender\LenderForm;

class FirstStepLenderForm extends LenderForm
{
    public function getInputNamesArray()
    {
        return array(
            'intCreditAmountFrom',
            'intCreditAmountTo',
            'intRepaymentTimeFrom',
            'intRepaymentTimeTo',
            'boolMortgage',
            'boolBillOfExchange',
            'boolCreditInsurance',
            'boolGuarantor',
            'bool777',
            'boolTakeOwnership',
        );
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('intCreditAmountFrom', 'hidden');
        $builder->add('intCreditAmountTo', 'hidden');
        $builder->add('intRepaymentTimeFrom', 'hidden');
        $builder->add('intRepaymentTimeTo', 'hidden');

        $builder->add('boolMortgage', 'checkbox', array(
            'required' => false,
        ));
        
        $builder->add('boolBillOfExchange', 'checkbox', array(
            'required' => false,
        ));
        
        $builder->add('boolCreditInsurance', 'checkbox', array(
            'required' => false,
        ));
        
        $builder->add('boolGuarantor', 'checkbox', array(
            'required' => false,
        ));
        
        $builder->add('bool777', 'checkbox', array(
            'required' => false,
        ));
        
        $builder->add('boolTakeOwnership', 'checkbox', array(
            'required' => false,
        ));
        
        $this->setDefault($builder);
    }

    public function setDefault(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        foreach ($this->getInputNamesArray() as $key) {
            $methodName = 'get' . ucfirst($key);
            $builder->get($key)->setData($this->getLenderCreator()->$methodName());
        }
    }

    public function save($arrValues)
    {
        $objLenderCreator = $this->getLenderCreator();
        foreach ($arrValues as $key => $arrValue) {
            $methodName = 'set' . ucfirst($key);
            $objLenderCreator->$methodName($arrValue);
        }
    }

}
