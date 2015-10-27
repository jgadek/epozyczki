<?php

namespace App\FrontendBundle\Controller;

use App\FrontendBundle\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use App\FrontendBundle\Utils\Session\LenderCreator;

class LenderDashboardController extends FrontendController
{

    public function indexAction(Request $request)
    {
        $objBrowser = new \App\FrontendBundle\Utils\Form\LenderDashboard\LenderDashboardBrowser($request, $this->getUser(), $this->getDoctrine()->getManager());

        $template = $request->isXmlHttpRequest() ? 'AppFrontendBundle:LenderDashboard:indexAjax.html.twig' : 'AppFrontendBundle:LenderDashboard:index.html.twig';

        return $this->render($template, array(
                    'sort_form' => $this->createForm($objBrowser->getSortForm())->createView(),
                    'filter_form' => $this->createForm($objBrowser->getFilterForm())->createView(),
                    'browser' => $objBrowser,
        ));
    }

    public function creditInfoAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $objCredit = $m->getRepository("DataBundle:Credit")->find($request->get('id'));
        if (!($objCredit instanceof \DataBundle\Entity\Credit)) {
            return $this->render('AcmeGlobalBundle:Base:ajaxError.html.twig', array(
                        'message' => 'Wybrany kredyt nie istnieje'
            ));
        }
        return $this->render('AppFrontendBundle:LenderDashboard:creditInfo.html.twig', array(
                    'credit' => $objCredit
        ));
    }

    public function preferencesAction(Request $request)
    {
        $objForm = new \App\FrontendBundle\Utils\Form\LenderDashboard\PreferencesForm($this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $objForm->save($this->getDoctrine()->getManager(), $form->getData());
                $this->get('session')->getFlashbag()->set('success', 'Dane zostały zaktualizowane');
                return $this->redirect($this->generateUrl("app_frontend_lender_dashboard_preferences"));
            }
        }
        return $this->render('AppFrontendBundle:LenderDashboard:preferences.html.twig', array(
                    'form' => $form->createView(),
                    'errors' => $objForm->getErrors(),
        ));
    }

    public function accountAction(Request $request)
    {
        $objForm = new \App\FrontendBundle\Utils\Form\LenderDashboard\AccountForm($this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid() && $this->checkUser($objForm, $form->getData())) {
                $objForm->save($this->getDoctrine()->getManager(), $form->getData());
                $this->get('session')->getFlashbag()->set('success', 'Dane zostały zaktualizowane');
                return $this->redirect($this->generateUrl("app_frontend_lender_dashboard_account"));
            }
        }
        return $this->render('AppFrontendBundle:LenderDashboard:account.html.twig', array(
                    'form' => $form->createView(),
                    'errors' => $objForm->getErrors(),
        ));
    }

    public function checkUser($objForm, $arrValues)
    {
        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($this->getUser());
        $encoded_pass = $encoder->encodePassword($arrValues['password'], $this->getUser()->getSalt());
        if ($this->getUser()->getPassword() !== $encoded_pass) {
            $objForm->addError('Hasło jest niepoprawne');
        }

        if ($this->getUser()->getUsername() !== $arrValues['username']) {
            $objForm->addError('Użytkownik jest niepoprawny');
        }

        if ($this->getUser()->getEmail() !== $arrValues['email']) {
            $objForm->addError('Email jest niepoprawny');
        }

        return $objForm->hasErrors() ? false : true;
    }

    public function offerCreditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objCredit = $em->getRepository('DataBundle:Credit')->find($request->get('id'));
        if (!$objCredit instanceof \DataBundle\Entity\Credit) {
            return null;
        }
        $objForm = new \App\FrontendBundle\Utils\Form\LenderDashboard\OfferCreateForm($objCredit);
        $form = $this->createForm($objForm);
        return $this->render('AppFrontendBundle:LenderDashboard:createOffer.html.twig', array(
                    'form' => $form->createView(),
                    'form_class' => json_encode('App\FrontendBundle\Utils\Form\LenderDashboard\OfferCreateForm'),
                    'credit' => $objCredit,
        ));
    }

    public function formOfferValidAjaxAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $objCredit = $em->getRepository('DataBundle:Credit')->find($request->get('id'));
        if (!$objCredit instanceof \DataBundle\Entity\Credit) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'error',
                        'message' => 'Nie odnaleziono kredytu',
            ));
        }
        $objForm = new \App\FrontendBundle\Utils\Form\LenderDashboard\OfferCreateForm($objCredit);
        $form = $this->createForm($objForm);
        $form->handleRequest($request);
        if ($form->isValid()) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'success'
            ));
        }
        $arrErrors = $form->getErrors();
        return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                    'status' => 'error',
                    'errors' => $arrErrors,
        ));
    }

    public function offerCreditCreateAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $objCredit = $em->getRepository('DataBundle:Credit')->find($request->get('id'));
        if (!$objCredit instanceof \DataBundle\Entity\Credit) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'error',
                        'message' => 'Nie odnaleziono kredytu',
            ));
        }
        /* @var $objCredit \DataBundle\Entity\Credit */
        if ($objCredit->hasOfferFromUser($this->getUser())) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'error',
                        'message' => 'Złożyłeś już wcześniej ofertę dla tego wniosku',
            ));
        }

        if (!$objCredit->getStepWaitToOffer()) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'error',
                        'message' => 'Status wniosku nie pozwala na złożenie oferty',
            ));
        }
        $objForm = new \App\FrontendBundle\Utils\Form\LenderDashboard\OfferCreateForm($objCredit);
        $form = $this->createForm($objForm);
        $form->handleRequest($request);
        $data = $form->getData();

        $dtExpiredAt = new \DateTime($data["expiredAt"]);

        $objOffer = new \DataBundle\Entity\Offer();
        $objOffer
                ->setCredit($objCredit)
                ->setLender($this->getUser())
                ->setAmountOffered((int) $data['amount'])
                ->setReplaymentTime((int) $data['replaymentTime'])
                ->setReplaymentMethod((int) $data['replaymentMethod'])
                ->setInterest((int) $data['interest'])
                ->setTypeOfSecurity($data['typeOfSecurity'])
                ->setDescription($data['description'])
                ->setExpiredAt($dtExpiredAt);
        $objOffer->save($em);
        $em->persist($objOffer);
        $em->flush();

        $view = $this->renderView('AcmeGlobalBundle:Email:newOffer.html.twig', array(
            'credit' => $objCredit,
            'user' => $objCredit->getGuardUser(),
        ));

        $this->sendEmailUsers($objCredit->getGuardUser(), 'epozyczki.pl - nowa oferta', $view);
        return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                    'status' => 'success',
                    'message' => 'Oferta została złożona',
        ));
    }

    public function sendMessageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objCredit = $em->getRepository('DataBundle:Credit')->find($request->get('id'));
        if (!$objCredit instanceof \DataBundle\Entity\Credit) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'error',
                        'message' => 'Nie odnaleziono kredytu',
            ));
        }
        $objMessage = new \DataBundle\Entity\Message();
        $objMessage
                ->setContent($request->get('content'))
                ->setCredit($objCredit)
                ->setGuardUser($this->getUser());
        $em->persist($objMessage);
        $em->flush();
        
        $this->sendEmailUsers(array($objCredit->getGuardUser()), 'epozyczki.pl - nowa wiadomość', $this->renderView('AcmeGlobalBundle:Email:sendQuestion.html.twig', array(
            'user' => $objCredit->getGuardUser(),
            'from' => $this->getUser(),
            'credit' => $objCredit,
        )));
        
        return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                    'status' => 'success',
                    'message' => 'Wiadomość została dodana',
        ));
    }

}
