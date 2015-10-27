<?php

namespace App\FrontendBundle\Utils\Form\Credit;

use App\FrontendBundle\Utils\Form\Credit\CreditForm;
use App\FrontendBundle\Utils\Session\CreditCreator;
use App\GuardBundle\Entity\GuardUser;

class ThirdStepCreditForm extends CreditForm
{

    public function getInputNamesArray()
    {
        return array(
            'strFirstName',
            'strSecondName',
            'strLastName',
            'strPesel',
            'strEdg',
            'strIdNumber',
            'strAddress',
            'strPostCode',
            'strCity',
            'strPhone',
            'strFacebookAddress'
        );
    }

    public function getInputRequired($key)
    {
        $array = array(
            'strFirstName' => true,
            'strSecondName' => false,
            'strLastName' => true,
            'strPesel' => true,
            'strEdg' => false,
            'strIdNumber' => true,
            'strAddress' => true,
            'strPostCode' => true,
            'strCity' => true,
            'strPhone' => true,
            'strFacebookAddress' => true
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
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strSecondName', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Drugie imię',
                'data-required' => 'false',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strLastName', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nazwisko',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPesel', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'PESEL',
                'data-required' => 'true',
                'pattern' => '^[0-9]{11}$',
            )
        ));

        $builder->add('strEdg', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'EDG dla działalności gosp.',
                'data-required' => 'false',
                'pattern' => '^.{0,255}$',
            )
        ));

        $builder->add('strIdNumber', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nr dowodu osobistego',
                'data-required' => 'true',
                'pattern' => '^.{3}[0-9]{6}$',
            )
        ));

        $builder->add('strAddress', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres zamieszkania',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPostCode', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Kod pocztowy',
                'data-required' => 'true',
                'pattern' => '^(\d\d\d\d\d|\d\d-\d\d\d)$',
            )
        ));

        $builder->add('strCity', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Miescowość',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPhone', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Telefon',
                'data-required' => 'true',
                'pattern' => '^(\+)?[0-9\s\-]{9,15}$',
            )
        ));

        $builder->add('strFacebookAddress', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres profilu na Facebook',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
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
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strSecondName2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Drugie imię',
                'data-required' => 'false',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strLastName2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nazwisko',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPesel2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'PESEL',
                'data-required' => 'true',
                'pattern' => '^[0-9]{11}$',
            )
        ));

        $builder->add('strEdg2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'EDG dla działalności gosp.',
                'data-required' => 'false',
                'pattern' => '^.{0,255}$',
            )
        ));

        $builder->add('strIdNumber2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nr dowodu osobistego',
                'data-required' => 'true',
                'pattern' => '^.{3}[0-9]{6}$',
            )
        ));

        $builder->add('strAddress2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres zamieszkania',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPostCode2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Kod pocztowy',
                'data-required' => 'true',
                'pattern' => '^(\d\d\d\d\d|\d\d-\d\d\d)$',
            )
        ));

        $builder->add('strCity2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Miescowość',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        $builder->add('strPhone2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Telefon',
                'data-required' => 'true',
                'pattern' => '^(\+)?[0-9\s\-]{9,15}$',
            )
        ));
        
        $builder->add('strFacebookAddress2', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres profilu na Facebook',
                'data-required' => 'true',
                'pattern' => '^.{1,255}$',
            )
        ));

        if (!$this->getUser() instanceof GuardUser) {
            $builder->add('username', 'text', array(
                'attr' => array(
                    'placeholder' => 'Nick',
                    'data-required' => 'true',
                    'pattern' => '^.{1,255}$',
                )
            ));
            
            $patternEmail = '^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$';

            $builder->add('email', 'text', array(
                'attr' => array(
                    'placeholder' => 'e-mail',
                    'data-required' => 'true',
                    'pattern' => $patternEmail,
                )
            ));

            $builder->add('password', 'password', array(
                'attr' => array(
                    'placeholder' => 'hasło',
                    'data-required' => 'true',
                    'pattern' => '^.{1,255}$',
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

    private function __clean($column, $value)
    {
        if($column === 'strPhone2' || $column === 'strPhone') {
            $value = preg_replace('/[^\d]/', '', $value);
        }
        
        return trim($value);
    }


    public function save($arrValues)
    {
        $objCreditCreator = $this->getCreditCreator();
        foreach ($arrValues as $key => $arrValue) {
            if ($arrValues['intTypeOfPerson'] == CreditCreator::TYPE_OF_PERSON_NATURAL) {
                if (preg_match('/.+\d$/', $key)) {
                    continue;
                }
                $methodName = 'set' . ucfirst($key);
            } else {
                if (!preg_match('/.+\d$/', $key)) {
                    continue;
                }
                $methodName = 'set' . preg_replace('/^(.+)(\d)$/', '\\1', ucfirst($key));
            }
            $objCreditCreator->$methodName($this->__clean($key, $arrValue));
        }
        $objCreditCreator->setIntTypeOfPerson($arrValues['intTypeOfPerson']);
        if (!$this->getUser() instanceof GuardUser) {
            $objCreditCreator->setUsername($arrValues['username']);
            $objCreditCreator->setEmail($arrValues['email']);
            $objCreditCreator->setPassword($arrValues['password']);
        }
    }

}
