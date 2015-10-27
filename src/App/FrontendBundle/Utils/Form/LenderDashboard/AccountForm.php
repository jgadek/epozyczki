<?php

namespace App\FrontendBundle\Utils\Form\LenderDashboard;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\GuardBundle\Entity\GuardUser;
use App\FrontendBundle\Utils\Session\LenderCreator;

class AccountForm extends AbstractType
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

        $builder->add('intTypeOfPerson', 'choice', array(
            'choices' => LenderCreator::GetTypesOfPersonToDropDown(),
            'expanded' => true,
            'multiple' => false,
            'data' => $this->getUser()->getTypeOfPerson()
        ));

        /**
         * LEWA STRONA
         */
        $builder->add('strFirstNameNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Imię',
                'data-required' => 'true',
            ),
        ));

        $builder->add('strSecondNameNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Drugie imię',
                'data-required' => 'false',
            ),
        ));

        $builder->add('strLastNameNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nazwisko',
                'data-required' => 'true',
            ),
        ));

        $builder->add('strPeselNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'PESEL',
                'data-required' => 'true',
            ),
        ));

        $builder->add('strIdNumberNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nr dowodu osobistego',
                'data-required' => 'true',
            ),
        ));

        $builder->add('strAddressNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres zamieszkania',
                'data-required' => 'true',
            ),
        ));

        $builder->add('strPostCodeNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Kod pocztowy',
                'data-required' => 'true',
            ),
        ));

        $builder->add('strCityNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Miescowość',
                'data-required' => 'true',
            ),
        ));

        $builder->add('strPhoneNatural', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Telefon',
                'data-required' => 'true',
            ),
        ));


        /**
         * PRAWA STRONA
         */
        $builder->add('strNameOfCorporationLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Nazwa firmy',
                'data-required' => 'true',
            )
        ));

        $builder->add('strRepresentativeLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Reprezentant',
                'data-required' => 'true',
            )
        ));

        $builder->add('strKrsOrEdgLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'KRS lub nr wpisu EDG',
                'data-required' => 'true',
            )
        ));

        $builder->add('strNipLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'NIP',
                'data-required' => 'true',
            )
        ));

        $builder->add('strRegonLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'REGON',
                'data-required' => 'true',
            )
        ));

        $builder->add('strAddressLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Adres siedziby',
                'data-required' => 'true',
            )
        ));

        $builder->add('strPostCodeLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Kod pocztowy',
                'data-required' => 'true',
            )
        ));

        $builder->add('strCityLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Miescowość',
                'data-required' => 'true',
            )
        ));

        $builder->add('strPhoneLegal', 'text', array(
            'required' => false,
            'attr' => array(
                'placeholder' => 'Telefon',
                'data-required' => 'true',
            )
        ));

        $builder->add('username', 'text', array(
            'attr' => array(
                'placeholder' => 'nick',
            ),
            'data' => $this->getUser()->getUsername(),
        ));

        $builder->add('email', 'text', array(
            'attr' => array(
                'placeholder' => 'e-mail',
            ),
            'data' => $this->getUser()->getEmail(),
        ));

        $builder->add('password', 'password', array(
            'attr' => array(
                'placeholder' => 'hasło',
            ),
        ));

        $this->setDefault($builder);
    }

    public function setDefault(\Symfony\Component\Form\FormBuilderInterface $builder)
    {
        if ($this->getUser()->getTypeOfPerson() === LenderCreator::TYPE_OF_PERSON_NATURAL) {
            $builder->get('strFirstNameNatural')->setData($this->getUser()->getFirstName());
            $builder->get('strSecondNameNatural')->setData($this->getUser()->getSecondName());
            $builder->get('strLastNameNatural')->setData($this->getUser()->getLastName());
            $builder->get('strPeselNatural')->setData($this->getUser()->getPesel());
            $builder->get('strIdNumberNatural')->setData($this->getUser()->getIdNumber());
            $builder->get('strAddressNatural')->setData($this->getUser()->getAddress());
            $builder->get('strPostCodeNatural')->setData($this->getUser()->getPostCode());
            $builder->get('strCityNatural')->setData($this->getUser()->getCity());
            $builder->get('strPhoneNatural')->setData($this->getUser()->getPhone());
        }

        if ($this->getUser()->getTypeOfPerson() === LenderCreator::TYPE_OF_PERSON_LEGAL) {
            $builder->get('strNameOfCorporationLegal')->setData($this->getUser()->getNameOfCorporation());
            $builder->get('strRepresentativeLegal')->setData($this->getUser()->getRepresentative());
            $builder->get('strKrsOrEdgLegal')->setData($this->getUser()->getEdg());
            $builder->get('strNipLegal')->setData($this->getUser()->getNip());
            $builder->get('strRegonLegal')->setData($this->getUser()->getRegon());
            $builder->get('strAddressLegal')->setData($this->getUser()->getAddress());
            $builder->get('strPostCodeLegal')->setData($this->getUser()->getPostCode());
            $builder->get('strCityLegal')->setData($this->getUser()->getCity());
            $builder->get('strPhoneLegal')->setData($this->getUser()->getPhone());
        }
    }

    public function save(\Doctrine\ORM\EntityManager $em, $arrValues)
    {
        $this->getUser()->clearLender();
        
        if ((int) $arrValues['intTypeOfPerson'] === LenderCreator::TYPE_OF_PERSON_NATURAL) {
            $this->getUser()->setFirstName($arrValues['strFirstNameNatural']);
            $this->getUser()->setSecondName($arrValues['strSecondNameNatural']);
            $this->getUser()->setLastName($arrValues['strLastNameNatural']);
            $this->getUser()->setPesel($arrValues['strPeselNatural']);
            $this->getUser()->setIdNumber($arrValues['strIdNumberNatural']);
            $this->getUser()->setAddress($arrValues['strAddressNatural']);
            $this->getUser()->setPostCode($arrValues['strPostCodeNatural']);
            $this->getUser()->setCity($arrValues['strCityNatural']);
            $this->getUser()->setPhone($arrValues['strPhoneNatural']);
        }
        if ((int) $arrValues['intTypeOfPerson'] === LenderCreator::TYPE_OF_PERSON_LEGAL) {
            $this->getUser()->setNameOfCorporation($arrValues['strNameOfCorporationLegal']);
            $this->getUser()->setRepresentative($arrValues['strRepresentativeLegal']);
            $this->getUser()->setEdg($arrValues['strKrsOrEdgLegal']);
            $this->getUser()->setNip($arrValues['strNipLegal']);
            $this->getUser()->setRegon($arrValues['strRegonLegal']);
            $this->getUser()->setAddress($arrValues['strAddressLegal']);
            $this->getUser()->setPostCode($arrValues['strPostCodeLegal']);
            $this->getUser()->setCity($arrValues['strCityLegal']);
            $this->getUser()->setPhone($arrValues['strPhoneLegal']);
        }
        $this->getUser()->setTypeOfPerson((int) $arrValues['intTypeOfPerson']);
        
        $em->flush();
    }

    public function getName()
    {
        return 'account_form';
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
    
}
