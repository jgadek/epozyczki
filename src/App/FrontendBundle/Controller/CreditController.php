<?php

namespace App\FrontendBundle\Controller;

use App\FrontendBundle\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use App\FrontendBundle\Utils\Session\CreditCreator;

class CreditController extends FrontendController
{

    public function firstStepAction(Request $request)
    {
        $objForm = new \App\FrontendBundle\Utils\Form\Credit\FirstStepCreditForm($this->getCreditCreator(), $this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $objForm->save($form->getData());
                $this->saveCreditCreator($objForm->getCreditCreator()->serialize());
                return $this->redirect($this->generateUrl("app_frontend_credit_secondStep"));
            }
        }
        return $this->render('AppFrontendBundle:Credit:firstStep.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function secondStepAction(Request $request)
    {
        $objForm = new \App\FrontendBundle\Utils\Form\Credit\SecondStepCreditForm($this->getCreditCreator(), $this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $objForm->save($form->getData());
                $this->saveCreditCreator($objForm->getCreditCreator()->serialize());
                return $this->redirect($this->generateUrl("app_frontend_credit_thirdStep"));
            }
        }
        return $this->render('AppFrontendBundle:Credit:secondStep.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function thirdStepAction(Request $request)
    {
        $objForm = new \App\FrontendBundle\Utils\Form\Credit\ThirdStepCreditForm($this->getCreditCreator(), $this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $objForm->save($form->getData());
                $this->saveCreditCreator($objForm->getCreditCreator()->serialize());
                return $this->redirect($this->generateUrl("app_frontend_credit_fourthStep"));
            }
        }
        return $this->render('AppFrontendBundle:Credit:thirdStep.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function fourthStepAction(Request $request)
    {
        $objCreator = $this->getCreditCreator();
        $objForm = new \App\FrontendBundle\Utils\Form\Credit\FourStepCreditForm($objCreator, $this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid() && $objCreator->isValid($this->getUser())) {
                $objUser = $this->getUserForCredit($objCreator);
                if (!$objCreator->hasErrors()) {
                    $objForm->setUser($objUser);
                    $objForm->save($this->getDoctrine()->getManager());
                    if ($objCreator->isNew()) {
                        $this->sendEmailRegister($objForm->getUser());
                    }
                    $this->sendEmailCreatedCredit($objForm->getUser(), $objForm->getCredit(), $objCreator->isNew());
                    $this->removeCreditCreator();
                    if (!$objCreator->hasErrors()) {
                        return $this->redirect($this->generateUrl('app_frontend_credit_thankYou'));
                    }
                }
            }
        }
        return $this->render('AppFrontendBundle:Credit:fourthStep.html.twig', array(
                    'form' => $form->createView(),
                    'creator' => $objCreator,
        ));
    }

    /**
     * 
     * @param \App\FrontendBundle\Utils\Session\CreditCreator $objCreator
     * @return \App\GuardBundle\Entity\GuardUser
     */
    public function getUserForCredit(CreditCreator $objCreator)
    {
        /**
         * Zwraca zalogowanego usera
         */
        if ($this->getUser() instanceof \App\GuardBundle\Entity\GuardUser) {
            if ($this->getUser()->hasRole(\App\GuardBundle\Entity\GuardUser::ROLE_LENDER)) {
                $objCreator->addError('Osoba zalogowania jako pożyczkodawca nie może wziąć pożyczki');
                return null;
            }
            return $this->getUser();
        }

        $m = $this->getDoctrine()->getManager();

        /**
         * Sprawdza czy istnieje user o podanym emailu i username
         */
        /* @var $activeUser \App\GuardBundle\Entity\GuardUser */
        $activeUser = $m->getRepository('AppGuardBundle:GuardUser')->findOneBy(array(
            'username' => $objCreator->getUsername(),
            'email' => $objCreator->getEmail()
        ));

        if ($activeUser instanceof \App\GuardBundle\Entity\GuardUser) {
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($activeUser);
            $encoded_pass = $encoder->encodePassword($objCreator->getPassword(), $activeUser->getSalt());
            if ($activeUser->getPassword() !== $encoded_pass) {
                $objCreator->addError('Hasło jest niepoprawne');
                return null;
            }
            if ($activeUser->hasRole(\App\GuardBundle\Entity\GuardUser::ROLE_LENDER)) {
                $objCreator->addError('Nie można użyć tych danych do wzięcia pożyczki. Użytkownik jest pożyczkodawcą');
                return null;
            }
            if (!$activeUser->hasRole(\App\GuardBundle\Entity\GuardUser::ROLE_BORROWER)) {
                $objCreator->addError('Nie można użyć tych danych do wzięcia pożyczki.');
                return null;
            }
            return $activeUser;
        }


        $activeUser = $m->getRepository('AppGuardBundle:GuardUser')->findOneBy(array(
            'username' => $objCreator->getUsername()
        ));

        if ($activeUser instanceof \App\GuardBundle\Entity\GuardUser) {
            $objCreator->addError('Adres email lub nick jest niepoprawny');
            return null;
        }

        $activeUser = $m->getRepository('AppGuardBundle:GuardUser')->findOneBy(array(
            'email' => $objCreator->getEmail()
        ));

        if ($activeUser instanceof \App\GuardBundle\Entity\GuardUser) {
            $objCreator->addError('Adres email lub nick jest niepoprawny');
            return null;
        }


        $caller = $this->get('api_caller');
        $arrParams = array(
            'username' => $objCreator->getUsername(),
            'password' => $objCreator->getPassword(),
            'email' => $objCreator->getEmail(),
            'roles' => array(\App\GuardBundle\Entity\GuardUser::ROLE_BORROWER, \App\GuardBundle\Entity\GuardUser::ROLE_DEFAULT)
        );
        $url = $this->generateUrl("post_user", $arrParams, true);
        $objHttp = new \Lsw\ApiCallerBundle\Call\HttpPostJson($url, array());
        $data = $caller->call($objHttp);

        $objCreator->setIsNew(TRUE);
        return $m->getRepository('AppGuardBundle:GuardUser')->findOneByUsername($objCreator->getUsername());
    }

    public function sendEmailCreatedCredit(\App\GuardBundle\Entity\GuardUser $objUser, \DataBundle\Entity\Credit $objCredit, $isNew)
    {
        $view = $this->renderView('AcmeGlobalBundle:Email:createdCredit.html.twig', array(
            'credit' => $objCredit,
            'user' => $objUser
        ));
        $this->sendEmailUsers($objUser, 'e-pozyczki.pl - utworzenie kredytu', $view);

        if ($isNew) {
            $viewAdminUser = $this->renderView('AcmeGlobalBundle:AdminEmail:createdUser.html.twig', array(
                'user' => $objUser,
                'new' => $isNew,
            ));
            $this->sendEmailAdmin('e-pozyczki.pl - utworzenie użytkownika', $viewAdminUser);
        }

        $viewAdminCredit = $this->renderView('AcmeGlobalBundle:AdminEmail:createdCredit.html.twig', array(
            'credit' => $objCredit,
            'user' => $objUser,
            'new' => $isNew,
        ));
        $this->sendEmailAdmin('e-pozyczki.pl - utworzenie kredytu', $viewAdminCredit);
    }

    public function thankYouAction(Request $request)
    {
        return $this->render('AppFrontendBundle:Credit:thankYou.html.twig');
    }

}
