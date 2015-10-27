<?php

namespace App\FrontendBundle\Utils\Form\Credit;

use App\FrontendBundle\Utils\Form\Credit\CreditForm;
use App\FrontendBundle\Utils\Session\CreditCreator;

class SecondStepCreditForm extends CreditForm
{

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('strPurpose', 'text', array(
            'attr' => array(
                'placeholder' => 'Cel pożyczki',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPurposeDescription', 'textarea', array(
            'attr' => array(
                'placeholder' => 'Szczegółowy opis celu pożyczki',
                'pattern' => '^.+$',
            )
        ));

        $builder->add('intRepaymentMethod', 'choice', array(
            'choices' => CreditCreator::GetReplaymentMethodsToDropDown(),
            'placeholder' => 'Sposób spłaty pożyczki',
        ));

        $builder->add('intSourceOfIncome', 'choice', array(
            'choices' => CreditCreator::GetSourceOfIncomesToDropDown(),
            'placeholder' => 'Źródło przychodów',
        ));

        $builder->add('intSalary', 'text', array(
            'attr' => array(
                'placeholder' => 'Dochody miesięczne',
                'pattern' => '^\d{1,8}$',
            )
        ));
        $builder->add('intMaritalStatus', 'choice', array(
            'choices' => CreditCreator::GetMaritalStatusesToDropDown(),
            'placeholder' => 'Stan cywilny',
        ));
        $builder->add('intNumberOfChildren', 'choice', array(
            'choices' => CreditCreator::GetNumbersOfChildrenToDropDown(),
            'placeholder' => 'Ilość dzieci',
        ));
        $builder->add('strTypeOfSecurity', 'text', array(
            'attr' => array(
                'placeholder' => 'Rodzaj zabezpieczenia',
                'pattern' => '^.{1,255}$',
            )
        ));
        $builder->add('strTypeOfSecurityDescription', 'textarea', array(
            'attr' => array(
                'placeholder' => 'Szczegółowy opis zabezpieczenia pożyczki',
                'pattern' => '^.+$',
            )
        ));
        
        $builder->add('filesName', 'text', array(
            'required' => false,
            'attr' => array(
                'readonly' => true,
                'placeholder' => 'Dokumenty, zdjęcia',
                'class' => 'selectedFiles',
            )
        ));
        
        $builder->add('files', 'file', array(
            'attr' => array(
                'class' => 'selectFiles',
                'style' => 'display: none;'
            ),
            'required' => false,
            'multiple' => true
        ));

        $this->setDefault($builder);
    }

    public function setDefault(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        $arrKeys = array(
            'strPurpose',
            'strPurposeDescription',
            'intRepaymentMethod',
            'intSourceOfIncome',
            'intSalary',
            'intMaritalStatus',
            'intNumberOfChildren',
            'strTypeOfSecurity',
            'strTypeOfSecurityDescription',
        );

        foreach ($arrKeys as $key) {
            $methodName = 'get' . ucfirst($key);
            $builder->get($key)->setData($this->getCreditCreator()->$methodName());
        }
        
        $files = $this->getCreditCreator()->getFiles();
        $filesNames = array();
        foreach ($files as $file) {
            $filesNames[] = $file['filename'];
        }
        
        $builder->get('filesName')->setData(join(', ', $filesNames));

    }

    public function save($arrValues)
    {
        $objCreditCreator = $this->getCreditCreator();
        foreach ($arrValues as $key => $arrValue) {
            if($key === 'filesName') {
                continue;
            }
            $methodName = 'set' . ucfirst($key);
            $objCreditCreator->$methodName($arrValue);
        }
    }

}
