<?php

namespace App\FrontendBundle\Utils\Form\Borrower;

use Acme\Utils\Form\BaseForm;
use DataBundle\Entity\Credit;

class CreditInfoForm extends BaseForm
{

    private $objCredit;

    public function __construct(Credit $objCredit)
    {
        $this->objCredit = $objCredit;
    }

    public function getCredit()
    {
        return $this->objCredit;
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);


        $builder->add('intCreditAmount', 'hidden', array(
            'data' => $this->getCredit()->getCreditAmount()
        ));

        $builder->add('intRepaymentTime', 'hidden', array(
            'data' => $this->getCredit()->getReplaymentTime()
        ));

        $builder->add('intRepaymentMethod', 'choice', array(
            'choices' => \App\FrontendBundle\Utils\Session\CreditCreator::GetReplaymentMethodsToDropDown(),
            'placeholder' => 'Sposób spłaty pożyczki',
            'data' => $this->getCredit()->getReplaymentMethod(),
        ));

        $builder->add('strPurpose', 'text', array(
            'attr' => array(
                'placeholder' => 'Cel pożyczki',
            ),
            'data' => $this->getCredit()->getPurpose(),
        ));

        $builder->add('strTypeOfSecurity', 'text', array(
            'attr' => array(
                'placeholder' => 'Rodzaj zabezpieczenia',
            ),
            'data' => $this->getCredit()->getTypeOfSecurity(),
        ));

        $builder->add('strTypeOfSecurityDescription', 'textarea', array(
            'attr' => array(
                'placeholder' => 'Szczegółowy opis zabezpieczenia pożyczki'
            ),
            'data' => $this->getCredit()->getTypeOfSecurityDescription(),
        ));
    }

    public function getName()
    {
        return 'credit_info_form';
    }

    public function save(\Doctrine\ORM\EntityManager $em, $data = array())
    {
        $objCredit = $this->getCredit();
        $objCredit
                ->setCreditAmount($data['intCreditAmount'])
                ->setReplaymentTime($data['intRepaymentTime'])
                ->setReplaymentMethod($data['intRepaymentMethod'])
                ->setPurpose($data['strPurpose'])
                ->setTypeOfSecurity($data['strTypeOfSecurity'])
                ->setTypeOfSecurityDescription($data['strTypeOfSecurityDescription'])
        ;
        $em->flush();
    }

}
