<?php

namespace App\FrontendBundle\Utils\Form\LenderDashboard;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\GuardBundle\Entity\GuardUser;
use App\FrontendBundle\Utils\Session\LenderCreator;

class PreferencesForm extends AbstractType
{

    private $objUser;
    private $arrErrors;

    public function __construct(GuardUser $objUser)
    {
        $this->objUser = $objUser;
    }

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

    /**
     * @return GuardUser
     */
    protected function getUser()
    {
        return $this->objUser;
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

        $builder->add('boolEmailConfirm', 'checkbox', array(
            'required' => false,
        ));

        $this->setDefault($builder);
    }

    public function setDefault(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        $builder->get('intCreditAmountFrom')->setData($this->getUser()->getLenderAmountFrom());
        $builder->get('intCreditAmountTo')->setData($this->getUser()->getLenderAmountTo());
        $builder->get('intRepaymentTimeFrom')->setData($this->getUser()->getLenderReplaymentTimeForm());
        $builder->get('intRepaymentTimeTo')->setData($this->getUser()->getLenderReplaymentTimeTo());
        $builder->get('boolMortgage')->setData($this->getUser()->getLenderMortgage());
        $builder->get('boolBillOfExchange')->setData($this->getUser()->getLenderBillOfExchange());
        $builder->get('boolCreditInsurance')->setData($this->getUser()->getLenderCreditInsurance());
        $builder->get('boolGuarantor')->setData($this->getUser()->getLenderGuarantor());
        $builder->get('bool777')->setData($this->getUser()->getLender777());
        $builder->get('boolTakeOwnership')->setData($this->getUser()->getLenderTakeOwnership());
        $builder->get('boolEmailConfirm')->setData($this->getUser()->getLenderEmailCredits());
    }

    public function save(\Doctrine\ORM\EntityManager $em, $arrValues)
    {
        $this->getUser()->setLenderAmountFrom($arrValues['intCreditAmountFrom']);
        $this->getUser()->setLenderAmountTo($arrValues['intCreditAmountTo']);
        $this->getUser()->setLenderReplaymentTimeForm($arrValues['intRepaymentTimeFrom']);
        $this->getUser()->setLenderReplaymentTimeTo($arrValues['intRepaymentTimeTo']);
        $this->getUser()->setLenderMortgage($arrValues['boolMortgage']);
        $this->getUser()->setLenderBillOfExchange($arrValues['boolBillOfExchange']);
        $this->getUser()->setLenderCreditInsurance($arrValues['boolCreditInsurance']);
        $this->getUser()->setLenderGuarantor($arrValues['boolGuarantor']);
        $this->getUser()->setLender777($arrValues['bool777']);
        $this->getUser()->setLenderTakeOwnership($arrValues['boolTakeOwnership']);
        $this->getUser()->setLenderEmailCredits($arrValues['boolEmailConfirm']);
        $em->flush();
    }

    public function addError($error)
    {
        $this->arrErrors[] = $error;
    }

    public function getErrors()
    {
        return $this->arrErrors;
    }

    public function hasErrors()
    {
        return count($this->arrErrors) ? true : false;
    }

    public function getName()
    {
        return 'proferences_form';
    }

}
