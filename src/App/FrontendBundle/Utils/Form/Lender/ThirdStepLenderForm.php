<?php

namespace App\FrontendBundle\Utils\Form\Lender;

use App\FrontendBundle\Utils\Form\Lender\LenderForm;
use App\FrontendBundle\Utils\Session\LenderCreator;
use App\GuardBundle\Entity\GuardUser;

class ThirdStepLenderForm extends LenderForm
{

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('acceptConditions', 'checkbox', array(
            'required' => false,
            'attr' => array(
                'data-error' => 'Proszę zaznaczyć zaakceptowanie regulaminu'
            ),
        ));

        $builder->add('acceptPersonalData', 'checkbox', array(
            'required' => false,
            'attr' => array(
                'data-error' => 'Proszę zaznaczyć wyrażenie zgody na przetwarzanie danych osobowych'
            ),
        ));

        $builder->add('acceptPricing', 'checkbox', array(
            'required' => false,
            'attr' => array(
                'data-error' => 'Proszę zaznaczyć pole z zapoznaniem się z warunkami serwisu i cennikiem'
            ),
        ));
    }

    public function save(\Doctrine\ORM\EntityManager $em)
    {
        $objLender = $this->getLenderCreator();
        $objUser = $this->getUser();

        try {
            $em->beginTransaction();
            $objUser
                    ->setTypeOfPerson($objLender->getIntTypeOfPerson())
                    ->setLenderAmountFrom($objLender->getIntCreditAmountFrom())
                    ->setLenderAmountTo($objLender->getIntCreditAmountTo())
                    ->setLenderReplaymentTimeForm($objLender->getIntRepaymentTimeFrom())
                    ->setLenderReplaymentTimeTo($objLender->getIntRepaymentTimeTo())
                    ->setLenderMortgage($objLender->getBoolMortgage())
                    ->setLender777($objLender->getBool777())
                    ->setLenderTakeOwnership($objLender->getBoolTakeOwnership())
                    ->setLenderCreditInsurance($objLender->getBoolCreditInsurance())
                    ->setLenderGuarantor($objLender->getBoolGuarantor())
                    ->setLenderBillOfExchange($objLender->getBoolBillOfExchange())
            ;
            if ($objLender->getIntTypeOfPersonIsLegal()) {
                $objUser
                        ->setNameOfCorporation($objLender->getStrNameOfCorporationLegal())
                        ->setRepresentative($objLender->getStrRepresentativeLegal())
                        ->setEdg($objLender->getStrKrsOrEdgLegal())
                        ->setNip($objLender->getStrNipLegal())
                        ->setRegon($objLender->getStrRegonLegal())
                        ->setAddress($objLender->getStrAddressLegal())
                        ->setPostCode($objLender->getStrPostCodeLegal())
                        ->setCity($objLender->getStrCityLegal())
                        ->setPhone($objLender->getStrPhoneLegal())
                ;
            } else {
                $objUser
                        ->setFirstName($objLender->getStrFirstNameNatural())
                        ->setSecondName($objLender->getStrSecondNameNatural())
                        ->setLastName($objLender->getStrLastNameNatural())
                        ->setPesel($objLender->getStrPeselNatural())
                        ->setIdNumber($objLender->getStrIdNumberNatural())
                        ->setAddress($objLender->getStrAddressNatural())
                        ->setPostCode($objLender->getStrPostCodeNatural())
                        ->setCity($objLender->getStrCityNatural())
                        ->setPhone($objLender->getStrPhoneNatural())
                ;
            }
            
            $em->flush();

            $em->commit();
        } catch (\Exception $e) {
            $em->rollback();
//            echo $e->getMessage();
            $em->remove($objUser);
            $em->flush();
            $this->getLenderCreator()->addError("Wystąpiły problemy po stronie serwera. Informacja została zgłoszona do administratora");
            $this->getCreditCreator()->addError("Prosimy spróbować jeszcze raz wysłać wniosek");
            //MIEJSCE NA WYSŁANIE MAILA
        }
    }

}
