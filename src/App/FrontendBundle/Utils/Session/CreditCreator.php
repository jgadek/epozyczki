<?php

namespace App\FrontendBundle\Utils\Session;

class CreditCreator
{

    protected $arrErrors = array();

    /**
     * STEP 1
     */
    protected
            $intCreditAmount,
            $intRepaymentTime
    ;

    /**
     * STEP 2
     */
    protected
            $strPurpose,
            $strPurposeDescription,
            $intRepaymentMethod,
            $intSourceOfIncome,
            $intSalary,
            $intMaritalStatus,
            $intNumberOfChildren,
            $strTypeOfSecurity,
            $strTypeOfSecurityDescription,
            $files
    ;

    /**
     * STEP 3
     */
    protected
            $intTypeOfPerson,
            $strFirstName,
            $strSecondName,
            $strLastName,
            $strPesel,
            $strEdg,
            $strIdNumber,
            $strAddress,
            $strPostCode,
            $strCity,
            $strPhone,
            $strFacebookAddress
    ;
    protected $is_new = false;
    protected static $arrValidators = array(
        'intCreditAmount' => array(
            'required' => true,
            'regex' => '/^\d{1,10}$/',
            'invalid' => 'Kwota pożyczki: Niepoprawna wartość',
            'required_text' => 'Kwota pożyczki: Pole wymagane',
        ),
        'intRepaymentTime' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Okres spłaty: Niepoprawna wartość',
            'required_text' => 'Okres spłaty: Pole wymagane',
        ),
        'strPurpose' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Cel pożyczki: Niepoprawna wartość',
            'required_text' => 'Cel pożyczki: Pole wymagane',
        ),
        'intRepaymentMethod' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Sposób spłaty pożyczki: Niepoprawna wartość',
            'required_text' => 'Sposób spłaty pożyczki: Pole wymagane',
        ),
        'intSourceOfIncome' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Źródło przychodów: Niepoprawna wartość',
            'required_text' => 'Źródło przychodów: Pole wymagane',
        ),
        'intSalary' => array(
            'required' => true,
            'regex' => '/^\d{1,12}$/',
            'invalid' => 'Dochody miesięczne: Niepoprawna wartość',
            'required_text' => 'Dochody miesięczne: Pole wymagane',
        ),
        'intMaritalStatus' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Stan cywilny: Niepoprawna wartość',
            'required_text' => 'Stan cywilny: Pole wymagane',
        ),
        'intNumberOfChildren' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Ilość dzieci: Niepoprawna wartość',
            'required_text' => 'Ilość dzieci: Pole wymagane',
        ),
        'strTypeOfSecurity' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Rodzaj zabezpieczenia: Niepoprawna wartość',
            'required_text' => 'Rodzaj zabezpieczenia: Pole wymagane',
        ),
        'strTypeOfSecurityDescription' => array(
            'required' => true,
            'regex' => '/^.+$/',
            'invalid' => 'Szczegółowy opis zabezpieczenia pożyczki: Niepoprawna wartość',
            'required_text' => 'Szczegółowy opis zabezpieczenia pożyczki: Pole wymagane',
        ),
        'intTypeOfPerson' => array(
            'required' => true,
            'regex' => '/^\d{1,3}$/',
            'invalid' => 'Typ osoby: Niepoprawna wartość',
            'required_text' => 'Typ osoby: Pole wymagane',
        ),
        'strFirstName' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Imię: Niepoprawna wartość',
            'required_text' => 'Imię: Pole wymagane',
        ),
        'strSecondName' => array(
            'required' => false,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Drugie imię: Niepoprawna wartość',
            'required_text' => 'Drugie imię: Pole wymagane',
        ),
        'strLastName' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Nazwisko: Niepoprawna wartość',
            'required_text' => 'Nazwisko: Pole wymagane',
        ),
        'strPesel' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'PESEL: Niepoprawna wartość',
            'required_text' => 'PESEL: Pole wymagane',
        ),
        'strEdg' => array(
            'required' => false,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'EDG: Niepoprawna wartość',
            'required_text' => 'EDG: Pole wymagane',
        ),
        'strIdNumber' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Nr dowodu osobistego: Niepoprawna wartość',
            'required_text' => 'Nr dowodu osobistego: Pole wymagane',
        ),
        'strAddress' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Adres zamieszkania: Niepoprawna wartość',
            'required_text' => 'Adres zamieszkania: Pole wymagane',
        ),
        'strPostCode' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Kod pocztowy: Niepoprawna wartość',
            'required_text' => 'Kod pocztowy: Pole wymagane',
        ),
        'strCity' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Miescowość: Niepoprawna wartość',
            'required_text' => 'Miescowość: Pole wymagane',
        ),
        'strPhone' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Telefon: Niepoprawna wartość',
            'required_text' => 'Telefon: Pole wymagane',
        ),
        'strFacebookAddress' => array(
            'required' => true,
            'regex' => '/^.{1,255}$/',
            'invalid' => 'Adres profilu na Facebook: Niepoprawna wartość',
            'required_text' => 'Adres profilu na Facebook: Pole wymagane',
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

    /**
     * LOGIN INFO
     */
    protected
            $username,
            $email,
            $password

    ;

    CONST REPLAYMENT_METHOD_EQUAL = 1;
    CONST REPLAYMENT_METHOD_ALL_ON_THE_END = 2;

    protected static $arrReplaymentMethods = array(
        self::REPLAYMENT_METHOD_EQUAL => 'w równych ratach miesiecznych',
        self::REPLAYMENT_METHOD_ALL_ON_THE_END => 'całość na koniec pożyczki',
    );

    public static function GetReplaymentMethodsToDropDown()
    {
        return self::$arrReplaymentMethods;
    }

    public static function GetReplaymentMethodToString($key)
    {
        return self::$arrReplaymentMethods[$key];
    }

    CONST MARITAL_STATUS_SINGLE = 1;
    CONST MARITAL_STATUS_MARRIED = 2;

    protected static $arrMaritalStatuses = array(
        self::MARITAL_STATUS_SINGLE => 'Kawaler/Panna',
        self::MARITAL_STATUS_MARRIED => 'Żonaty/Zamężny',
    );

    public static function GetMaritalStatusesToDropDown()
    {
        return self::$arrMaritalStatuses;
    }

    public static function GetMaritalStatuseLabel($key)
    {
        return self::$arrMaritalStatuses[$key];
    }

    CONST SOURCE_OF_INCOME_CONTRACT = 1;
    CONST SOURCE_OF_INCOME_OWN_BUSINESS = 2;
    CONST SOURCE_OF_INCOME_PENSION = 3;
    CONST SOURCE_OF_INCOME_OTHER = 4;

    protected static $arrSourceOfIncomes = array(
        self::SOURCE_OF_INCOME_CONTRACT => 'Umowa o pracę',
        self::SOURCE_OF_INCOME_OWN_BUSINESS => 'Własna działalność',
        self::SOURCE_OF_INCOME_PENSION => 'Emerytura',
        self::SOURCE_OF_INCOME_OTHER => 'Inne',
    );

    public static function GetSourceOfIncomesToDropDown()
    {
        return self::$arrSourceOfIncomes;
    }

    public static function GetSourceOfIncomeToString($key)
    {
        return self::$arrSourceOfIncomes[$key];
    }

    CONST NUMBER_OF_CHILDER_NONE = 1;
    CONST NUMBER_OF_CHILDER_ONE = 2;
    CONST NUMBER_OF_CHILDER_TWO = 3;
    CONST NUMBER_OF_CHILDER_THREE = 4;
    CONST NUMBER_OF_CHILDER_FOUR = 5;
    CONST NUMBER_OF_CHILDER_FIVE = 6;
    CONST NUMBER_OF_CHILDER_MORE = 7;

    protected static $arrNumbersOfChildren = array(
        self::NUMBER_OF_CHILDER_NONE => 'brak',
        self::NUMBER_OF_CHILDER_ONE => '1',
        self::NUMBER_OF_CHILDER_TWO => '2',
        self::NUMBER_OF_CHILDER_THREE => '3',
        self::NUMBER_OF_CHILDER_FOUR => '4',
        self::NUMBER_OF_CHILDER_FIVE => '5',
        self::NUMBER_OF_CHILDER_MORE => 'więcej niż 5',
    );

    public static function GetNumbersOfChildrenToDropDown()
    {
        return self::$arrNumbersOfChildren;
    }

    public static function GetNumbersOfChildrenLabel($key)
    {
        return self::$arrNumbersOfChildren[$key];
    }

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

    CONST DEFAULT_AMOUNT = 100000;
    CONST DEFAULT_REPLAY = 12;

    public function __construct()
    {
        $this->setIntTypeOfPerson(self::TYPE_OF_PERSON_NATURAL);
        $this->setIntCreditAmount(self::DEFAULT_AMOUNT);
        $this->setIntRepaymentTime(self::DEFAULT_REPLAY);
    }

    public function serialize()
    {
        return serialize($this);
    }

    /**
     * 
     * @param string $strSerialized
     * @return CreditCreator
     */
    public static function unserialized($strSerialized = null)
    {
        if ($strSerialized === null) {
            return new CreditCreator();
        }
        /* @var $objCreditCreator CreditCreator */
        $objCreditCreator = unserialize($strSerialized);
        return $objCreditCreator;
    }

    public function getIntCreditAmount()
    {
        return $this->intCreditAmount;
    }

    public function getIntRepaymentTime()
    {
        return $this->intRepaymentTime;
    }

    public function getStrPurpose()
    {
        return $this->strPurpose;
    }

    public function getStrPurposeDescription()
    {
        return $this->strPurposeDescription;
    }

    public function getIntRepaymentMethod()
    {
        return $this->intRepaymentMethod;
    }

    public function getIntRepaymentMethodLabel()
    {
        return key_exists($this->intRepaymentMethod, self::$arrReplaymentMethods) ? self::$arrReplaymentMethods[$this->intRepaymentMethod] : '';
    }

    public function getIntSourceOfIncome()
    {
        return $this->intSourceOfIncome;
    }

    public function getIntSourceOfIncomeLabel()
    {
        return key_exists($this->intSourceOfIncome, self::$arrSourceOfIncomes) ? self::$arrSourceOfIncomes[$this->intSourceOfIncome] : '';
    }

    public function getIntSalary()
    {
        return $this->intSalary;
    }

    public function getIntMaritalStatus()
    {
        return $this->intMaritalStatus;
    }

    public function getIntMaritalStatusLabel()
    {
        return key_exists($this->intMaritalStatus, self::$arrMaritalStatuses) ? self::$arrMaritalStatuses[$this->intMaritalStatus] : '';
    }

    public function getIntNumberOfChildren()
    {
        return $this->intNumberOfChildren;
    }

    public function getIntNumberOfChildrenLabel()
    {
        return key_exists($this->intNumberOfChildren, self::$arrNumbersOfChildren) ? self::$arrNumbersOfChildren[$this->intNumberOfChildren] : '';
    }

    public function getStrTypeOfSecurity()
    {
        return $this->strTypeOfSecurity;
    }

    public function getStrTypeOfSecurityDescription()
    {
        return $this->strTypeOfSecurityDescription;
    }

    public function getFiles()
    {
        return is_array($this->files) ? $this->files : array();
    }

    public function getIntTypeOfPerson()
    {
        return $this->intTypeOfPerson;
    }

    public function getIntTypeOfPersonLabel()
    {
        return key_exists($this->intTypeOfPerson, self::$arrTypesOfPerson) ? self::$arrTypesOfPerson[$this->intTypeOfPerson] : '';
    }

    public function getStrFirstName()
    {
        return $this->strFirstName;
    }

    public function getStrSecondName()
    {
        return $this->strSecondName;
    }

    public function getStrLastName()
    {
        return $this->strLastName;
    }

    public function getStrPesel()
    {
        return $this->strPesel;
    }

    public function getStrEdg()
    {
        return $this->strEdg;
    }

    public function getStrIdNumber()
    {
        return $this->strIdNumber;
    }

    public function getStrAddress()
    {
        return $this->strAddress;
    }

    public function getStrPostCode()
    {
        return $this->strPostCode;
    }

    public function getStrCity()
    {
        return $this->strCity;
    }

    public function getStrPhone()
    {
        return $this->strPhone;
    }

    public function getStrFacebookAddress()
    {
        return $this->strFacebookAddress;
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

    public function setIntCreditAmount($intCreditAmount)
    {
        $this->intCreditAmount = $intCreditAmount;
    }

    public function setIntRepaymentTime($intRepaymentTime)
    {
        $this->intRepaymentTime = $intRepaymentTime;
    }

    public function setStrPurpose($strPurpose)
    {
        $this->strPurpose = $strPurpose;
    }

    public function setStrPurposeDescription($strPurposeDescription)
    {
        $this->strPurposeDescription = $strPurposeDescription;
    }

    public function setIntRepaymentMethod($intRepaymentMethod)
    {
        $this->intRepaymentMethod = $intRepaymentMethod;
    }

    public function setIntSourceOfIncome($intSourceOfIncome)
    {
        $this->intSourceOfIncome = $intSourceOfIncome;
    }

    public function setIntSalary($intSalary)
    {
        $this->intSalary = $intSalary;
    }

    public function setIntMaritalStatus($intMaritalStatus)
    {
        $this->intMaritalStatus = $intMaritalStatus;
    }

    public function setIntNumberOfChildren($intNumberOfChildren)
    {
        $this->intNumberOfChildren = $intNumberOfChildren;
    }

    public function setStrTypeOfSecurity($strTypeOfSecurity)
    {
        $this->strTypeOfSecurity = $strTypeOfSecurity;
    }

    public function setStrTypeOfSecurityDescription($strTypeOfSecurityDescription)
    {
        $this->strTypeOfSecurityDescription = $strTypeOfSecurityDescription;
    }

    public function setFiles($files)
    {
        $arrFiles = array();
        foreach ($files as $file) {
            if ($file === null) {
                continue;
            }
            /* @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
            $arrFile = array(
                'filename' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'base64' => base64_encode(file_get_contents($file->getRealPath()))
            );
            $arrFiles[] = $arrFile;
        }
        $this->files = $arrFiles;
    }

    public function setIntTypeOfPerson($intTypeOfPerson)
    {
        $this->intTypeOfPerson = $intTypeOfPerson;
    }

    public function setStrFirstName($strFirstName)
    {
        $this->strFirstName = $strFirstName;
    }

    public function setStrSecondName($strSecondName)
    {
        $this->strSecondName = $strSecondName;
    }

    public function setStrLastName($strLastName)
    {
        $this->strLastName = $strLastName;
    }

    public function setStrPesel($strPesel)
    {
        $this->strPesel = $strPesel;
    }

    public function setStrEdg($strEdg)
    {
        $this->strEdg = $strEdg;
    }

    public function setStrIdNumber($strIdNumber)
    {
        $this->strIdNumber = $strIdNumber;
    }

    public function setStrAddress($strAddress)
    {
        $this->strAddress = $strAddress;
    }

    public function setStrPostCode($strPostCode)
    {
        $this->strPostCode = $strPostCode;
    }

    public function setStrCity($strCity)
    {
        $this->strCity = $strCity;
    }

    public function setStrPhone($strPhone)
    {
        $this->strPhone = $strPhone;
    }

    public function setStrFacebookAddress($strFacebookAddress)
    {
        $this->strFacebookAddress = $strFacebookAddress;
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

    public function setIsNew($bool)
    {
        $this->is_new = $bool;
    }

    public function isNew()
    {
        return $this->is_new === TRUE;
    }
    
    public function getFieldsNoValidUser()
    {
        return array(
            'password', 
        );
    }

    public function isValid(\App\GuardBundle\Entity\GuardUser $objUser = null)
    {
        foreach (self::$arrValidators as $key => $arrValidator) {
            if($objUser instanceof \App\GuardBundle\Entity\GuardUser && in_array($key, $this->getFieldsNoValidUser(), true)) {
                continue;
            }
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

    public function setUserData(\App\GuardBundle\Entity\GuardUser $objUser)
    {
        $this->setStrFirstName($objUser->getFirstName());
        $this->setStrSecondName($objUser->getSecondName());
        $this->setStrLastName($objUser->getLastName());
        $this->setStrCity($objUser->getCity());
        $this->setStrAddress($objUser->getAddress());
        $this->setStrEdg($objUser->getEdg());
        $this->setStrPesel($objUser->getPesel());
        $this->setStrFacebookAddress($objUser->getFacebook());
        $this->setIntTypeOfPerson($objUser->getTypeOfPerson());
        $this->setEmail($objUser->getEmail());
        $this->setUsername($objUser->getUsername());
        $this->setStrIdNumber($objUser->getIdNumber());
        $this->setStrPhone($objUser->getPhone());
        $this->setStrPostCode($objUser->getPostCode());
    }

}
