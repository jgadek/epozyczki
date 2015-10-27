<?php

namespace App\FrontendBundle\Utils\Form\Borrower;

use Acme\Utils\Form\BaseForm;

class BorrowerMyAccountForm extends BaseForm
{

    public function getInputNamesArray()
    {
        return array(
            'firstName',
            'secondName',
            'lastName',
            'pesel',
            'edg',
            'idNumber',
            'address',
            'postCode',
            'city',
            'phone',
            'facebookAddress'
        );
    }

    public function getInputRequired($key)
    {
        $array = array(
            'firstName' => true,
            'secondName' => false,
            'lastName' => true,
            'pesel' => true,
            'edg' => false,
            'idNumber' => true,
            'address' => true,
            'postCode' => true,
            'city' => true,
            'phone' => true,
            'facebookAddress' => true
        );
        return $array[$key];
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('intTypeOfPerson', 'choice', array(
            'choices' => CreditCreator::GetTypesOfPersonToDropDown(),
            'expanded' => true,
            'multiple' => false,
        ));

        /**
         * LEWA STRONA
         */
        $builder->add('strFirstName', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Imię',
                'data-required' => 'true',
            )
        ));

        $builder->add('strSecondName', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Drugie imię',
                'data-required' => 'false',
            )
        ));

        $builder->add('strLastName', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nazwisko',
                'data-required' => 'true',
            )
        ));

        $builder->add('strPesel', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'PESEL',
                'data-required' => 'true',
            )
        ));

        $builder->add('strEdg', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'EDG dla działalności gosp.',
                'data-required' => 'false',
            )
        ));

        $builder->add('strIdNumber', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nr dowodu osobistego',
                'data-required' => 'true',
            )
        ));

        $builder->add('strAddress', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres zamieszkania',
                'data-required' => 'true',
            )
        ));

        $builder->add('strPostCode', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Kod pocztowy',
                'data-required' => 'true',
            )
        ));

        $builder->add('strCity', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Miescowość',
                'data-required' => 'true',
            )
        ));

        $builder->add('strPhone', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Telefon',
                'data-required' => 'true',
            )
        ));

        $builder->add('strFacebookAddress', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres profilu na Facebook',
                'data-required' => 'true',
            )
        ));

        /**
         * PRAWA STRONA
         */
        $builder->add('strFirstName2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Imię',
                'data-required' => 'true',
            )
        ));

        $builder->add('strSecondName2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Drugie imię',
                'data-required' => 'false',
            )
        ));

        $builder->add('strLastName2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nazwisko',
                'data-required' => 'true',
            )
        ));

        $builder->add('strPesel2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'PESEL',
                'data-required' => 'true',
            )
        ));

        $builder->add('strEdg2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'EDG dla działalności gosp.',
                'data-required' => 'false',
            )
        ));

        $builder->add('strIdNumber2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nr dowodu osobistego',
                'data-required' => 'true',
            )
        ));

        $builder->add('strAddress2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres zamieszkania',
                'data-required' => 'true',
            )
        ));

        $builder->add('strPostCode2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Kod pocztowy',
                'data-required' => 'true',
            )
        ));

        $builder->add('strCity2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Miescowość',
                'data-required' => 'true',
            )
        ));

        $builder->add('strPhone2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Telefon',
                'data-required' => 'true',
            )
        ));

        $builder->add('strFacebookAddress2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres profilu na Facebook',
                'data-required' => 'true',
            )
        ));

        if (!$this->getUser() instanceof GuardUser) {
            $builder->add('username', 'text', array(
                'attr' => array(
                    'placeholder' => 'Nick',
                    'data-required' => 'true',
                )
            ));

            $builder->add('email', 'text', array(
                'attr' => array(
                    'placeholder' => 'e-mail',
                    'data-required' => 'true',
                )
            ));

            $builder->add('password', 'password', array(
                'attr' => array(
                    'placeholder' => 'hasło',
                    'data-required' => 'true',
                )
            ));
        }

        $this->setDefault($builder);
    }

    public function setDefault(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        $arrKeys = $this->getInputNamesArray();
        $builder->get('intTypeOfPerson')->setData($this->getCreditCreator()->getIntTypeOfPerson() !== null ? $this->getCreditCreator()->getIntTypeOfPerson() : CreditCreator::TYPE_OF_PERSON_NATURAL);

        foreach ($arrKeys as $key) {
            $methodName = 'get' . ucfirst($key);
            if ($this->getCreditCreator()->getIntTypeOfPerson() == CreditCreator::TYPE_OF_PERSON_LEGAL && $key !== 'intTypeOfPerson') {
                $keyN = $key . '2';
            } else {
                $keyN = $key;
            }
            $builder->get($keyN)->setData($this->getCreditCreator()->$methodName());
            $builder->get($keyN)->setRequired($this->getInputRequired($key));
        }

        if (!$this->getUser() instanceof GuardUser) {
            $builder->get('username')->setData($this->getCreditCreator()->getUsername());
            $builder->get('email')->setData($this->getCreditCreator()->getEmail());
            $builder->get('password')->setData($this->getCreditCreator()->getPassword());
        }
    }

    public function save($arrValues)
    {
    }

    public function getName()
    {
        return 'borrower_my_account_form';
    }

}
