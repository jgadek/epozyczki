<?php

namespace App\FrontendBundle\Utils\Session;

class LenderCreator
{

    protected $arrErrors = array();

    /**
     * STEP 1
     */
    protected
            $intCreditAmountFrom,
            $intCreditAmountTo,
            $intRepaymentTimeFrom,
            $intRepaymentTimeTo,
            $boolMortgage,
            $boolBillOfExchange,
            $boolCreditInsurance,
            $boolGuarantor,
            $bool777,
            $boolTakeOwnership
    ;

    /**
     * STEP 2
     */
    protected
            $intTypeOfPerson,
            $strFirstNameNatural,
            $strSecondNameNatural,
            $strLastNameNatural,
            $strPeselNatural,
            $strIdNumberNatural,
            $strAddressNatural,
            $strPostCodeNatural,
            $strCityNatural,
            $strPhoneNatural,
            $strNameOfCorporationLegal,
            $strRepresentativeLegal,
            $strKrsOrEdgLegal,
            $strNipLegal,
            $strRegonLegal,
            $strAddressLegal,
            $strPostCodeLegal,
            $strCityLegal,
            $strPhoneLegal
    ;
    protected static $arrValidators = array(
        'intCreditAmountFrom' => array(
            'required' => true,
            'regex' => '/^\d{1,10}$/',
            'invalid' => 'Kwota pożyczki: Niepoprawna wartość',
            'required_text' => 'Proszę zatwierdzić 1 krok. Kwota pożyczki Od: Pole wymagane',
        ),
        'intCreditAmountTo' => array(
            'required' => true,
            'regex' => '/^\d{1,10}$/',
            'invalid' => 'Kwota pożyczki: Niepoprawna wartość',
            'required_text' => 'Kwota pożyczki Do: Pole wymagane',
        ),
        'intRepaymentTimeFrom' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Okres spłaty: Niepoprawna wartość',
            'required_text' => 'Okres spłaty Od: Pole wymagane',
        ),
        'intRepaymentTimeTo' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Okres spłaty: Niepoprawna wartość',
            'required_text' => 'Okres spłaty Do: Pole wymagane',
        ),
        'intTypeOfPerson' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Typ osoby: Niepoprawna wartość',
            'required_text' => 'Proszę zatwierdzić 2 krok. Typ osoby: Pole wymagane',
        ),
        'username' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Nick: Niepoprawna wartość',
            'required_text' => 'Nick: Pole wymagane',
        ),
        'email' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'E-mail: Niepoprawna wartość',
            'required_text' => 'E-mail: Pole wymagane',
        ),
        'password' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Hasło: Niepoprawna wartość',
            'required_text' => 'Hasło: Pole wymagane',
        ),
    );
    protected static $arrValidatorsNatural = array(
        'strFirstNameNatural' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Imię: Niepoprawna wartość',
            'required_text' => 'Imię: Pole wymagane',
        ),
        'strSecondNameNatural' => array(
            'required' => false,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Drugie imię: Niepoprawna wartość',
            'required_text' => 'Drugie imię: Pole wymagane',
        ),
        'strLastNameNatural' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Nazwisko: Niepoprawna wartość',
            'required_text' => 'Nazwisko: Pole wymagane',
        ),
        'strPeselNatural' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'PESEL: Niepoprawna wartość',
            'required_text' => 'PESEL: Pole wymagane',
        ),
        'strIdNumberNatural' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Nr dowodu osobistego: Niepoprawna wartość',
            'required_text' => 'Nr dowodu osobistego: Pole wymagane',
        ),
        'strAddressNatural' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Adres zamieszkania: Niepoprawna wartość',
            'required_text' => 'Adres zamieszkania: Pole wymagane',
        ),
        'strPostCodeNatural' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Kod pocztowy: Niepoprawna wartość',
            'required_text' => 'Kod pocztowy: Pole wymagane',
        ),
        'strCityNatural' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Miescowość: Niepoprawna wartość',
            'required_text' => 'Miescowość: Pole wymagane',
        ),
        'strPhoneNatural' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Telefon: Niepoprawna wartość',
            'required_text' => 'Telefon: Pole wymagane',
        ),
    );
    protected static $arrValidatorsLegal = array(
        'strNameOfCorporationLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Nazwa firmy: Niepoprawna wartość',
            'required_text' => 'Nazwa firmy: Pole wymagane',
        ),
        'strRepresentativeLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Reprezentant: Niepoprawna wartość',
            'required_text' => 'Reprezentant: Pole wymagane',
        ),
        'strKrsOrEdgLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'KRS lub EDG: Niepoprawna wartość',
            'required_text' => 'KRS lub EDG: Pole wymagane',
        ),
        'strNipLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Nip: Niepoprawna wartość',
            'required_text' => 'Nip: Pole wymagane',
        ),
        'strRegonLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Regon: Niepoprawna wartość',
            'required_text' => 'Regon: Pole wymagane',
        ),
        'strAddressLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Adres: Niepoprawna wartość',
            'required_text' => 'Adres: Pole wymagane',
        ),
        'strPostCodeLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Kod pocztowy: Niepoprawna wartość',
            'required_text' => 'Kod pocztowy: Pole wymagane',
        ),
        'strCityLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Miasto: Niepoprawna wartość',
            'required_text' => 'Miasto: Pole wymagane',
        ),
        'strPhoneLegal' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Telefon: Niepoprawna wartość',
            'required_text' => 'Telefon: Pole wymagane',
        ),
    );

    /**
     * LOGIN INFO
     */
    protected
            $username,
            $email,
            $password

    ;

    CONST TYPE_OF_PERSON_NATURAL = 1;
    CONST TYPE_OF_PERSON_LEGAL = 2;

    protected static $arrTypesOfPerson = array(
        self::TYPE_OF_PERSON_NATURAL => 'Osoba fizyczna',
        self::TYPE_OF_PERSON_LEGAL => 'Osoba prawna'
    );

    public static function GetTypesOfPersonToDropDown()
    {
        return self::$arrTypesOfPerson;
    }

    protected static $arrRequiredSecurity = array(
        'boolMortgage' => 'Hipoteka',
        'boolBillOfExchange' => 'Weksel',
        'boolCreditInsurance' => 'Ubezpieczenie pożyczki',
        'boolGuarantor' => 'Poręczenie osoby trzeciej',
        'bool777' => '777 - dobrowolne poddanie się egzekucji',
        'boolTakeOwnership' => 'Przeywłaszczenie nieruchomości na czas pożyczki',
    );

    CONST DEFAULT_AMOUNT_FROM = 100000;
    CONST DEFAULT_AMOUNT_TO = 800000;
    CONST DEFAULT_REPLAY_FROM = 7;
    CONST DEFAULT_REPLAY_TO = 24;

    public function __construct()
    {
        $this->setIntTypeOfPerson(self::TYPE_OF_PERSON_NATURAL);
        $this->setIntCreditAmountFrom(self::DEFAULT_AMOUNT_FROM);
        $this->setIntCreditAmountTo(self::DEFAULT_AMOUNT_TO);
        $this->setIntRepaymentTimeFrom(self::DEFAULT_REPLAY_FROM);
        $this->setIntRepaymentTimeTo(self::DEFAULT_REPLAY_TO);
    }

    public function serialize()
    {
        return serialize($this);
    }

    /**
     * 
     * @param string $strSerialized
     * @return LenderCreator
     */
    public static function unserialized($strSerialized = null)
    {
        if ($strSerialized === null) {
            $objLender = new LenderCreator();
            return $objLender;
        }
        /* @var $objLenderCreator LenderCreator */
        $objLenderCreator = unserialize($strSerialized);
        return $objLenderCreator;
    }

    public function getIntCreditAmountFrom()
    {
        return $this->intCreditAmountFrom;
    }

    public function getIntCreditAmountFromLabel()
    {
        if ($this->intCreditAmountFrom > 1000000) {
            return preg_replace('/(\d+)(\d{3})(\d{3})/', '\\1 \\2 \\3', $this->intCreditAmountFrom);
        }
        return preg_replace('/(\d+)(\d{3})/', '\\1 \\2', $this->intCreditAmountFrom);
    }

    public function getIntCreditAmountTo()
    {
        return $this->intCreditAmountTo;
    }

    public function getIntCreditAmountToLabel()
    {
        if ($this->intCreditAmountTo > 1000000) {
            return preg_replace('/(\d+)(\d{3})(\d{3})/', '\\1 \\2 \\3', $this->intCreditAmountTo);
        }
        return preg_replace('/(\d+)(\d{3})/', '\\1 \\2', $this->intCreditAmountTo);
    }

    public function getIntRepaymentTimeFrom()
    {
        return $this->intRepaymentTimeFrom;
    }

    public function getIntRepaymentTimeTo()
    {
        return $this->intRepaymentTimeTo;
    }

    public function getIntTypeOfPerson()
    {
        return $this->intTypeOfPerson;
    }

    public function getIntTypeOfPersonLabel()
    {
        return key_exists($this->intTypeOfPerson, self::$arrTypesOfPerson) ? self::$arrTypesOfPerson[$this->intTypeOfPerson] : '';
    }

    public function getIntTypeOfPersonIsLegal()
    {
        return $this->intTypeOfPerson === self::TYPE_OF_PERSON_LEGAL;
    }

    public function getStrFirstNameNatural()
    {
        return $this->strFirstNameNatural;
    }

    public function getStrSecondNameNatural()
    {
        return $this->strSecondNameNatural;
    }

    public function getStrLastNameNatural()
    {
        return $this->strLastNameNatural;
    }

    public function getStrPeselNatural()
    {
        return $this->strPeselNatural;
    }

    public function getStrIdNumberNatural()
    {
        return $this->strIdNumberNatural;
    }

    public function getStrAddressNatural()
    {
        return $this->strAddressNatural;
    }

    public function getStrPostCodeNatural()
    {
        return $this->strPostCodeNatural;
    }

    public function getStrCityNatural()
    {
        return $this->strCityNatural;
    }

    public function getStrPhoneNatural()
    {
        return $this->strPhoneNatural;
    }

    public function getStrNameOfCorporationLegal()
    {
        return $this->strNameOfCorporationLegal;
    }

    public function getStrRepresentativeLegal()
    {
        return $this->strRepresentativeLegal;
    }

    public function getStrKrsOrEdgLegal()
    {
        return $this->strKrsOrEdgLegal;
    }

    public function getStrNipLegal()
    {
        return $this->strNipLegal;
    }

    public function getStrRegonLegal()
    {
        return $this->strRegonLegal;
    }

    public function getStrAddressLegal()
    {
        return $this->strAddressLegal;
    }

    public function getStrPostCodeLegal()
    {
        return $this->strPostCodeLegal;
    }

    public function getStrCityLegal()
    {
        return $this->strCityLegal;
    }

    public function getStrPhoneLegal()
    {
        return $this->strPhoneLegal;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPasswordHidden()
    {
        return preg_replace('/./', '*', $this->getPassword());
    }

    public function getBoolMortgage()
    {
        return $this->boolMortgage;
    }

    public function getBoolBillOfExchange()
    {
        return $this->boolBillOfExchange;
    }

    public function getBoolCreditInsurance()
    {
        return $this->boolCreditInsurance;
    }

    public function getBoolGuarantor()
    {
        return $this->boolGuarantor;
    }

    public function getBool777()
    {
        return $this->bool777;
    }

    public function getBoolTakeOwnership()
    {
        return $this->boolTakeOwnership;
    }

    public function setIntCreditAmountFrom($intCreditAmountFrom)
    {
        $this->intCreditAmountFrom = $intCreditAmountFrom;
    }

    public function setIntCreditAmountTo($intCreditAmountTo)
    {
        $this->intCreditAmountTo = $intCreditAmountTo;
    }

    public function setIntRepaymentTimeFrom($intRepaymentTimeFrom)
    {
        $this->intRepaymentTimeFrom = $intRepaymentTimeFrom;
    }

    public function setIntRepaymentTimeTo($intRepaymentTimeTo)
    {
        $this->intRepaymentTimeTo = $intRepaymentTimeTo;
    }

    public function setIntTypeOfPerson($intTypeOfPerson)
    {
        $this->intTypeOfPerson = $intTypeOfPerson;
    }

    public function setStrFirstNameNatural($strFirstNameNatural)
    {
        $this->strFirstNameNatural = $strFirstNameNatural;
    }

    public function setStrSecondNameNatural($strSecondNameNatural)
    {
        $this->strSecondNameNatural = $strSecondNameNatural;
    }

    public function setStrLastNameNatural($strLastNameNatural)
    {
        $this->strLastNameNatural = $strLastNameNatural;
    }

    public function setStrPeselNatural($strPeselNatural)
    {
        $this->strPeselNatural = $strPeselNatural;
    }

    public function setStrIdNumberNatural($strIdNumberNatural)
    {
        $this->strIdNumberNatural = $strIdNumberNatural;
    }

    public function setStrAddressNatural($strAddressNatural)
    {
        $this->strAddressNatural = $strAddressNatural;
    }

    public function setStrPostCodeNatural($strPostCodeNatural)
    {
        $this->strPostCodeNatural = $strPostCodeNatural;
    }

    public function setStrCityNatural($strCityNatural)
    {
        $this->strCityNatural = $strCityNatural;
    }

    public function setStrPhoneNatural($strPhoneNatural)
    {
        $this->strPhoneNatural = $strPhoneNatural;
    }

    public function setStrNameOfCorporationLegal($strNameOfCorporationLegal)
    {
        $this->strNameOfCorporationLegal = $strNameOfCorporationLegal;
    }

    public function setStrRepresentativeLegal($strRepresentativeLegal)
    {
        $this->strRepresentativeLegal = $strRepresentativeLegal;
    }

    public function setStrKrsOrEdgLegal($strKrsOrEdgLegal)
    {
        $this->strKrsOrEdgLegal = $strKrsOrEdgLegal;
    }

    public function setStrNipLegal($strNipLegal)
    {
        $this->strNipLegal = $strNipLegal;
    }

    public function setStrRegonLegal($strRegonLegal)
    {
        $this->strRegonLegal = $strRegonLegal;
    }

    public function setStrAddressLegal($strAddressLegal)
    {
        $this->strAddressLegal = $strAddressLegal;
    }

    public function setStrPostCodeLegal($strPostCodeLegal)
    {
        $this->strPostCodeLegal = $strPostCodeLegal;
    }

    public function setStrCityLegal($strCityLegal)
    {
        $this->strCityLegal = $strCityLegal;
    }

    public function setStrPhoneLegal($strPhoneLegal)
    {
        $this->strPhoneLegal = $strPhoneLegal;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setBoolMortgage($boolMortgage)
    {
        $this->boolMortgage = $boolMortgage;
    }

    public function setBoolBillOfExchange($boolBillOfExchange)
    {
        $this->boolBillOfExchange = $boolBillOfExchange;
    }

    public function setBoolCreditInsurance($boolCreditInsurance)
    {
        $this->boolCreditInsurance = $boolCreditInsurance;
    }

    public function setBoolGuarantor($boolGuarantor)
    {
        $this->boolGuarantor = $boolGuarantor;
    }

    public function setBool777($bool777)
    {
        $this->bool777 = $bool777;
    }

    public function setBoolTakeOwnership($boolTakeOwnership)
    {
        $this->boolTakeOwnership = $boolTakeOwnership;
    }

    public function getRequiredSecurityArray()
    {
        return self::$arrRequiredSecurity;
    }

    public function getRequiredSecurity()
    {
        $arrSelected = array();
        $i = 0;
        foreach ($this->getRequiredSecurityArray() as $key => $label) {
            $methodName = 'get' . ucfirst($key);
            if ($this->$methodName() === true) {
                $arrSelected[] = ( ++$i) . '. ' . $label;
            }
        }
        if (count($arrSelected)) {
            return join('<br />', $arrSelected);
        }
        return 'Brak wymaganych zabezpieczeń';
    }

    public function isValid()
    {
        foreach (self::$arrValidators as $key => $arrValidator) {
            $methodName = 'get' . ucfirst($key);
            $value = $this->$methodName();
            if ($arrValidator['required'] === FALSE && ($value == null || $value == '')) {
                continue;
            }
            if ($arrValidator['required'] === TRUE && ($value == null || $value == '')) {
                $this->addError($arrValidator['required_text']);
                continue;
            }
            if (!preg_match($arrValidator['regex'], $value)) {
                $this->addError($arrValidator['invalid']);
                continue;
            }
        }
        if ($this->getIntTypeOfPerson() === self::TYPE_OF_PERSON_LEGAL) {
            foreach (self::$arrValidatorsLegal as $key => $arrValidator) {
                $methodName = 'get' . ucfirst($key);
                $value = $this->$methodName();
                if ($arrValidator['required'] === FALSE && ($value == null || $value == '')) {
                    continue;
                }
                if ($arrValidator['required'] === TRUE && ($value == null || $value == '')) {
                    $this->addError($arrValidator['required_text']);
                    continue;
                }
                if (!preg_match($arrValidator['regex'], $value)) {
                    $this->addError($arrValidator['invalid']);
                    continue;
                }
            }
        } else {
            foreach (self::$arrValidatorsNatural as $key => $arrValidator) {
                $methodName = 'get' . ucfirst($key);
                $value = $this->$methodName();
                if ($arrValidator['required'] === FALSE && ($value == null || $value == '')) {
                    continue;
                }
                if ($arrValidator['required'] === TRUE && ($value == null || $value == '')) {
                    $this->addError($arrValidator['required_text']);
                    continue;
                }
                if (!preg_match($arrValidator['regex'], $value)) {
                    $this->addError($arrValidator['invalid']);
                    continue;
                }
            }
        }

        return $this->hasErrors() ? FALSE : TRUE;
    }

    public function addError($strError)
    {
        $this->arrErrors[] = $strError;
    }

    public function hasErrors()
    {
        return count($this->arrErrors) ? TRUE : FALSE;
    }

    public function getErrors()
    {
        return $this->arrErrors;
    }

}
