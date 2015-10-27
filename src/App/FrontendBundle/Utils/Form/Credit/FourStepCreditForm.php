<?php

namespace App\FrontendBundle\Utils\Form\Credit;

use App\FrontendBundle\Utils\Form\Credit\CreditForm;
use App\FrontendBundle\Utils\Session\CreditCreator;
use App\GuardBundle\Entity\GuardUser;

class FourStepCreditForm extends CreditForm
{

    private $objCredit;

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    private function setCredit(\DataBundle\Entity\Credit $objCredit)
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

    public function save(\Doctrine\ORM\EntityManager $em)
    {
        $objCreator = $this->getCreditCreator();
        $objUser = $this->getUser();


        try {
            $em->beginTransaction();
            $objCredit = new \DataBundle\Entity\Credit();

            $objCredit
                    ->setCreditAmount($objCreator->getIntCreditAmount())
                    ->setGuardUser($objUser)
                    ->setMaritalStatus($objCreator->getIntMaritalStatus())
                    ->setNumberOfChildren($objCreator->getIntNumberOfChildren())
                    ->setPurpose($objCreator->getStrPurpose())
                    ->setPurposeDescription($objCreator->getStrPurposeDescription())
                    ->setReplaymentMethod($objCreator->getIntRepaymentMethod())
                    ->setReplaymentTime($objCreator->getIntRepaymentTime())
                    ->setSalary($objCreator->getIntSalary())
                    ->setSourceOfIncome($objCreator->getIntSourceOfIncome())
                    ->setTypeOfSecurity($objCreator->getStrTypeOfSecurity())
                    ->setTypeOfSecurityDescription($objCreator->getStrTypeOfSecurityDescription())
            ;

            $objUser
                    ->setTypeOfPerson($objCreator->getIntTypeOfPerson())
                    ->setFirstName($objCreator->getStrFirstName())
                    ->setSecondName($objCreator->getStrSecondName())
                    ->setLastName($objCreator->getStrLastName())
                    ->setPesel($objCreator->getStrPesel())
                    ->setIdNumber($objCreator->getStrIdNumber())
                    ->setAddress($objCreator->getStrAddress())
                    ->setPostCode($objCreator->getStrPostCode())
                    ->setCity($objCreator->getStrCity())
                    ->setPhone($objCreator->getStrPhone())
                    ->setFacebook($objCreator->getStrFacebookAddress())
            ;

            if (!$this->getCreditCreator()->isNew()) {
                $objCredit->setStatus(\DataBundle\Entity\Credit::STATUS_ADMIN_VERIFICATION);
            }
            $objCredit->save($em);
            $em->persist($objCredit);
            $em->flush();

            foreach ($objCreator->getFiles() as $arrFile) {
                $objCreditFile = new \DataBundle\Entity\CreditFile();
                $objCreditFile->setFilename($arrFile['filename']);
                $objCreditFile->setMime($arrFile['mime']);
                $objCreditFile->setCredit($objCredit);
                $em->persist($objCreditFile);
                $em->flush();
                $objCreditFile->save($arrFile['base64']);
            }
            $this->setCredit($objCredit);

            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
            if ($this->getCreditCreator()->isNew()) {
                $em->remove($objUser);
            }
            $em->flush();
            $this->getCreditCreator()->addError("Wystąpiły problemy po stronie serwera. Informacja została zgłoszona do administratora");
            $this->getCreditCreator()->addError("Prosimy spróbować jeszcze raz wysłać wniosek");
            //MIEJSCE NA WYSŁANIE MAILA
        }
    }

}
