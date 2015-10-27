<?php

namespace App\FrontendBundle\Controller;

use App\FrontendBundle\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use App\FrontendBundle\Utils\Session\LenderCreator;

class LenderController extends FrontendController
{

    public function registerFirstStepAction(Request $request)
    {
        $objForm = new \App\FrontendBundle\Utils\Form\Lender\FirstStepLenderForm($this->getLenderCreator(), $this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $objForm->save($form->getData());
                $this->saveLenderCreator($objForm->getLenderCreator()->serialize());
                return $this->redirect($this->generateUrl("app_frontend_lender_registerSecondStep"));
            }
        }
        return $this->render('AppFrontendBundle:Lender:registerFirstStep.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function registerSecondStepAction(Request $request)
    {
        $objForm = new \App\FrontendBundle\Utils\Form\Lender\SecondStepLenderForm($this->getLenderCreator(), $this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $objForm->save($form->getData());
                $this->saveLenderCreator($objForm->getLenderCreator()->serialize());
                return $this->redirect($this->generateUrl("app_frontend_lender_registerThirdStep"));
            }
        }
        return $this->render('AppFrontendBundle:Lender:registerSecondStep.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    public function registerThirdStepAction(Request $request)
    {
        $objLender = $this->getLenderCreator();
        $objForm = new \App\FrontendBundle\Utils\Form\Lender\ThirdStepLenderForm($this->getLenderCreator(), $this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid() && $objLender->isValid()) {
                $objUser = $this->getUserForLender($objLender);
                if (!$objLender->hasErrors()) {
                    $objForm->setUser($objUser);
                    $objForm->save($this->getDoctrine()->getManager());
                    $this->sendEmailRegister($objForm->getUser());
                    $this->removeLenderCreator();
                    if (!$objLender->hasErrors()) {
                        return $this->redirect($this->generateUrl("app_frontend_lender_thankYou"));
                    }
                }
            }
        }
        return $this->render('AppFrontendBundle:Lender:registerThirdStep.html.twig', array(
                    'form' => $form->createView(),
                    'lender' => $objLender,
        ));
    }

    /**
     * 
     * @param LenderCreator $objLender
     * @return \App\GuardBundle\Entity\GuardUser
     */
    public function getUserForLender(LenderCreator $objLender)
    {
        $m = $this->getDoctrine()->getManager();


        $activeUser = $m->getRepository('AppGuardBundle:GuardUser')->findOneBy(array(
            'username' => $objLender->getUsername()
        ));

        if ($activeUser instanceof \App\GuardBundle\Entity\GuardUser) {
            $objLender->addError('Istnieje już użytkownik o podanym nicku');
            return null;
        }

        $activeUser = $m->getRepository('AppGuardBundle:GuardUser')->findOneBy(array(
            'email' => $objLender->getEmail()
        ));

        if ($activeUser instanceof \App\GuardBundle\Entity\GuardUser) {
            $objLender->addError('Istnieje już użytkownik o podanym adresie email');
            return null;
        }

        $caller = $this->get('api_caller');
        $arrParams = array(
            'username' => $objLender->getUsername(),
            'password' => $objLender->getPassword(),
            'email' => $objLender->getEmail(),
            'roles' => array(\App\GuardBundle\Entity\GuardUser::ROLE_LENDER, \App\GuardBundle\Entity\GuardUser::ROLE_DEFAULT)
        );
        $url = $this->generateUrl("post_user", $arrParams, true);
        $objHttp = new \Lsw\ApiCallerBundle\Call\HttpPostJson($url, array());
        $data = $caller->call($objHttp);

        return $m->getRepository('AppGuardBundle:GuardUser')->findOneByUsername($objLender->getUsername());
    }

    public function thankYouAction(Request $request)
    {
        return $this->render('AppFrontendBundle:Lender:thankYou.html.twig');
    }

}
