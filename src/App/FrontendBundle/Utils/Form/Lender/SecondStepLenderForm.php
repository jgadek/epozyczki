<?php

namespace App\FrontendBundle\Utils\Form\Lender;

use App\FrontendBundle\Utils\Form\Lender\LenderForm;
use App\FrontendBundle\Utils\Session\LenderCreator;
use App\GuardBundle\Entity\GuardUser;

class SecondStepLenderForm extends LenderForm
{

    public function getInputNamesArray()
    {
        return array(
            'strFirstNameNatural',
            'strSecondNameNatural',
            'strLastNameNatural',
            'strPeselNatural',
            'strIdNumberNatural',
            'strAddressNatural',
            'strPostCodeNatural',
            'strCityNatural',
            'strPhoneNatural',
            'strNameOfCorporationLegal',
            'strRepresentativeLegal',
            'strKrsOrEdgLegal',
            'strNipLegal',
            'strRegonLegal',
            'strAddressLegal',
            'strPostCodeLegal',
            'strCityLegal',
            'strPhoneLegal',
        );
    }

    public function getInputRequired($key)
    {
        $array = array(
            'strFirstNameNatural' => true,
            'strSecondNameNatural' => false,
            'strLastNameNatural' => true,
            'strPeselNatural' => true,
            'strIdNumberNatural' => true,
            'strAddressNatural' => true,
            'strPostCodeNatural' => true,
            'strCityNatural' => true,
            'strPhoneNatural' => true,
            'strNameOfCorporationLegal' => true,
            'strRepresentativeLegal' => true,
            'strKrsOrEdgLegal' => true,
            'strNipLegal' => true,
            'strRegonLegal' => true,
            'strAddressLegal' => true,
            'strPostCodeLegal' => true,
            'strCityLegal' => true,
            'strPhoneLegal' => true,
        );
        return $array[$key];
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('intTypeOfPerson', 'choice', array(
            'choices' => LenderCreator::GetTypesOfPersonToDropDown(),
            'expanded' => true,
            'multiple' => false,
        ));

        /**
         * LEWA STRONA
         */
        $builder->add('strFirstNameNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Imię',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strSecondNameNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Drugie imię',
                'data-required' => 'false',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strLastNameNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nazwisko',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPeselNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'PESEL',
                'data-required' => 'true',
                'pattern' => '^[0-9]{11}$',
            )
        ));

        $builder->add('strIdNumberNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nr dowodu osobistego',
                'data-required' => 'true',
                'pattern' => '^.{3}[0-9]{6}$',
            )
        ));

        $builder->add('strAddressNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres zamieszkania',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPostCodeNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Kod pocztowy',
                'data-required' => 'true',
                'pattern' => '^(\d\d\d\d\d|\d\d-\d\d\d)$',
            )
        ));

        $builder->add('strCityNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Miescowość',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPhoneNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Telefon',
                'data-required' => 'true',
                'pattern' => '^(\+)?[0-9\s\-]{9,15}$',
            )
        ));


        /**
         * PRAWA STRONA
         */
        $builder->add('strNameOfCorporationLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nazwa firmy',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strRepresentativeLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Reprezentant',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strKrsOrEdgLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'KRS lub nr wpisu EDG',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strNipLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'NIP',
                'data-required' => 'true',
                'pattern' => '^(\d{3}[- ]?\d{3}[- ]?\d{2}[- ]?\d{2})|(\d{3}[- ]?\d{2}[- ]?\d{2}[- ]?\d{3})$',
            )
        ));

        $builder->add('strRegonLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'REGON',
                'data-required' => 'true',
                'pattern' => '^(\d{9}|\d{14})$',
            )
        ));

        $builder->add('strAddressLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres siedziby',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPostCodeLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Kod pocztowy',
                'data-required' => 'true',
                'pattern' => '^(\d\d\d\d\d|\d\d-\d\d\d)$',
            )
        ));

        $builder->add('strCityLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Miescowość',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPhoneLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Telefon',
                'data-required' => 'true',
                'pattern' => '^(\+)?[0-9\s\-]{9,15}$',
            )
        ));

        $builder->add('username', 'text', array(
            'attr' => array(
                'placeholder' => 'nick',
                'pattern' => '^.{1,255}$',
            )
        ));

        $patternEmail = '^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$';
        
        $builder->add('email', 'text', array(
            'attr' => array(
                'placeholder' => 'e-mail',
                'pattern' => $patternEmail,
            )
        ));

        $builder->add('password', 'password', array(
            'attr' => array(
                'placeholder' => 'hasło',
                'pattern' => '^.{1,255}$',
            )
        ));

        $this->setDefault($builder);
    }

    public function setDefault(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        $arrKeys = $this->getInputNamesArray();
        $builder->get('intTypeOfPerson')->setData($this->getLenderCreator()->getIntTypeOfPerson() !== null ? $this->getLenderCreator()->getIntTypeOfPerson() : LenderCreator::TYPE_OF_PERSON_NATURAL);

        foreach ($arrKeys as $key) {
            $methodName = 'get' . ucfirst($key);
            $builder->get($key)->setData($this->getLenderCreator()->$methodName());
            if (($this->getLenderCreator()->getIntTypeOfPerson() === null || $this->getLenderCreator()->getIntTypeOfPerson() === LenderCreator::TYPE_OF_PERSON_NATURAL) && preg_match('/^.+Natural$/', $key)) {
                $builder->get($key)->setRequired($this->getInputRequired($key));
            }

            if ($this->getLenderCreator()->getIntTypeOfPerson() === LenderCreator::TYPE_OF_PERSON_LEGAL && preg_match('/^.+Legal$/', $key)) {
                $builder->get($key)->setRequired($this->getInputRequired($key));
            }
        }

        $builder->get('username')->setData($this->getLenderCreator()->getUsername());
        $builder->get('email')->setData($this->getLenderCreator()->getEmail());
        $builder->get('password')->setData($this->getLenderCreator()->getPassword());
    }

    public function save($arrValues)
    {
        $objLenderCreator = $this->getLenderCreator();
        foreach ($arrValues as $key => $arrValue) {
            $methodName = 'set' . ucfirst($key);
            $objLenderCreator->$methodName($arrValue);
        }
        $objLenderCreator->setIntTypeOfPerson($arrValues['intTypeOfPerson']);
        if (!$this->getUser() instanceof GuardUser) {
            $objLenderCreator->setUsername($arrValues['username']);
            $objLenderCreator->setEmail($arrValues['email']);
            $objLenderCreator->setPassword($arrValues['password']);
        }
    }

}
