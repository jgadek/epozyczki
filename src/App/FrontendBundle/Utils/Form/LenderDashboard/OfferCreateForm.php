<?php

namespace App\FrontendBundle\Utils\Form\LenderDashboard;

use Acme\Utils\Form\BaseForm;

class OfferCreateForm extends BaseForm
{

    private $objOffer;
    private $objCredit;

    public function __construct(\DataBundle\Entity\Credit $objCredit)
    {
        $this->objCredit = $objCredit;
    }

    /**
     * 
     * @return \DataBundle\Entity\Credit
     */
    public function getCredit()
    {
        return $this->objCredit;
    }

    public function setOffer(\DataBundle\Entity\Offer $objOffer)
    {
        $this->objOffer = $objOffer;
    }

    /**
     * 
     * @return \DataBundle\Entity\Offer
     */
    public function getOffer()
    {
        return $this->objOffer;
    }

    public function createOffer()
    {
        return new \DataBundle\Entity\Offer();
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('amount', 'hidden', array(
            'data' => $this->getCredit()->getCreditAmount(),
        ));
        $builder->add('replaymentTime', 'hidden', array(
            'data' => $this->getCredit()->getReplaymentTime(),
        ));

        $builder->add('interest', 'text', array(
            'attr' => array(
                'placeholder' => 'Oprocentowanie',
                'regex' => '\d+',
            ),
        ));

        $builder->add('typeOfSecurity', 'text', array(
            'attr' => array(
                'placeholder' => 'Rodzaj zabezpieczenia',
                'regex' => '.{1,255}',
            ),
            'data' => $this->getCredit()->getTypeOfSecurity()
        ));

        $builder->add('replaymentMethod', 'choice', array(
            'choices' => \App\FrontendBundle\Utils\Session\CreditCreator::GetReplaymentMethodsToDropDown(),
            'placeholder' => 'Sposób spłaty pożyczki',
            'data' => $this->getCredit()->getReplaymentMethod()
        ));
        
        $builder->add('description', 'textarea', array(
            'attr' => array(
                'placeholder' => 'Uwagi',
                'regex' => '.+',
            ),
        ));
        
        $builder->add('expiredAt', 'text', array(
            'attr' => array(
                'placeholder' => 'Ważność oferty',
                'regex' => '\d\d\.\d\d\.\d\d\d\d',
            ),
        ));
        
    }

    public function getName()
    {
        return 'create_offer';
    }

    public function save()
    {
        
    }

}
