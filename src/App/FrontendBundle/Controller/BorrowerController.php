<?php

namespace App\FrontendBundle\Controller;

use App\FrontendBundle\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;

class BorrowerController extends FrontendController
{

    public function myApplicationsAction(Request $request)
    {
        $objBrowser = new \App\FrontendBundle\Utils\Form\Borrower\BorrowerBrowser($request, $this->getUser(), $this->getDoctrine()->getManager());

        $template = $request->isXmlHttpRequest() ? 'AppFrontendBundle:Borrower:myApplicationsAjax.html.twig' : 'AppFrontendBundle:Borrower:myApplications.html.twig';

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
        return $this->render('AppFrontendBundle:Borrower:creditInfo.html.twig', array(
                    'credit' => $objCredit,
                    'form_info' => $this->createForm($this->getFormCreditInfo($objCredit))->createView()
        ));
    }

    public function detailsFormSaveAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $objCredit = $m->getRepository("DataBundle:Credit")->find($request->get('id'));
        /* @var $objCredit \DataBundle\Entity\Credit */
        if (!($objCredit instanceof \DataBundle\Entity\Credit)) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'error',
                        'message' => 'Wybrany kredyt nie istnieje',
            ));
        }
        $objForm = $this->getFormCreditInfo($objCredit);
        $form = $this->createForm($objForm);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $objForm->save($m, $form->getData());
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'success',
                        'message' => 'Zmieniono dane',
            ));
        }
        return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                    'status' => 'error-valid',
                    'message' => (string) $form->getErrors(true, false),
        ));
    }

    public function getFormCreditInfo(\DataBundle\Entity\Credit $objCredit)
    {
        return new \App\FrontendBundle\Utils\Form\Borrower\CreditInfoForm($objCredit);
    }

    public function offerInfoAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $objOffer = $m->getRepository("DataBundle:Offer")->find($request->get('id'));
        if (!($objOffer instanceof \DataBundle\Entity\Offer)) {
            return $this->render('AcmeGlobalBundle:Base:ajaxError.html.twig', array(
                        'message' => 'Wybrana oferta nie istnieje'
            ));
        }
        return $this->render('AppFrontendBundle:Borrower:offerInfo.html.twig', array(
                    'offer' => $objOffer,
        ));
    }

    public function creditCancelAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $objCredit = $m->getRepository("DataBundle:Credit")->find($request->get('id'));
        /* @var $objCredit \DataBundle\Entity\Credit */
        if (!($objCredit instanceof \DataBundle\Entity\Credit)) {
            $this->get('session')->getFlashbag()->set('error', 'Wybrany wniosek nie istnieje');
            return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
        }

        if (!$this->isWriteableCredit($objCredit)) {
            $this->get('session')->getFlashbag()->set('error', 'Nie jesteś właścicielem wniosku!');
            return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
        }

        $objCredit->setStatus(\DataBundle\Entity\Credit::STATUS_BORROWER_REJECTED);
        $m->flush();
        $this->get('session')->getFlashbag()->set('success', 'Anulowano wniosek');
        return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
    }

    public function offerAcceptAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        /* @var $objOffer \DataBundle\Entity\Offer */
        $objOffer = $m->getRepository("DataBundle:Offer")->find($request->get('id'));
        if (!($objOffer instanceof \DataBundle\Entity\Offer)) {
            $this->get('session')->getFlashbag()->set('error', 'Wybrana oferta nie istnieje');
            return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
        }
        $objCredit = $objOffer->getCredit();
        if (!$this->isWriteableCredit($objCredit)) {
            $this->get('session')->getFlashbag()->set('error', 'Nie jesteś właścicielem wniosku!');
            return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
        }

        $objCredit->setLender($objOffer->getLender());
        $objCredit->setStatus(\DataBundle\Entity\Credit::STATUS_BORROWER_ACCEPTED);
        
        
        $objOffer->setStatus(\DataBundle\Entity\Offer::STATUS_ACCEPTED);

        $m->getRepository("DataBundle:Offer")->rejectByOfferAccepted($objOffer);
        $collUsers = $m->getRepository("AppGuardBundle:GuardUser")->getToRejectByOfferAccepted($objOffer);

        $m->flush();

        foreach ($collUsers as $objRejectUser) {
            $this->sendEmailUsers($objRejectUser, 'epozyczki.pl - odrzucenie oferty', $this->renderView('AcmeGlobalBundle:Email:rejectOffer.html.twig', array(
                    'offer' => $objOffer,
                    'user' => $objRejectUser,
                    'credit' => $objOffer->getCredit(),
            )));
        }

        $this->sendEmailUsers($objOffer->getLender(), 'epozyczki.pl - akceptacja oferty', $this->renderView('AcmeGlobalBundle:Email:rejectAccepted.html.twig', array(
                    'offer' => $objOffer,
                    'user' => $objOffer->getLender(),
                    'credit' => $objOffer->getCredit(),
        )));

        $this->get('session')->getFlashbag()->set('success', 'Oferta została przyjęta');
        return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
    }

    public function offerCancelAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        /* @var $objOffer \DataBundle\Entity\Offer */
        $objOffer = $m->getRepository("DataBundle:Offer")->find($request->get('id'));
        if (!($objOffer instanceof \DataBundle\Entity\Offer)) {
            $this->get('session')->getFlashbag()->set('error', 'Wybrana oferta nie istnieje');
            return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
        }
        $objCredit = $objOffer->getCredit();
        if (!$this->isWriteableCredit($objCredit)) {
            $this->get('session')->getFlashbag()->set('error', 'Nie jesteś właścicielem wniosku!');
            return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
        }

        $objOffer->setStatus(\DataBundle\Entity\Offer::STATUS_REJECTED);
        $m->flush();

        $this->sendEmailUsers($objOffer->getLender(), 'epozyczki.pl - odrzucenie oferty', $this->renderView('AcmeGlobalBundle:Email:rejectOffer.html.twig', array(
                    'offer' => $objOffer,
                    'user' => $objOffer->getLender()
        )));

        $this->get('session')->getFlashbag()->set('success', 'Oferta została odrzucona');
        return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
    }

    public function myAccountAction(Request $request)
    {
        return $this->render('AppFrontendBundle:Borrower:myAccount.html.twig', array(
        ));
    }

    public function sendReplyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /* @var $objMessage \DataBundle\Entity\Message */
        $objMessage = $em->getRepository("DataBundle:Message")->find($request->get('id'));
        if (!$objMessage instanceof \DataBundle\Entity\Message) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'error',
                        'message' => 'Nie odnaleziono wiadomości',
            ));
        }
        if($objMessage->getStatus() === \DataBundle\Entity\Message::STATUS_REPLY) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'error',
                        'message' => 'Wcześniej już odpowiedziałeś na tę wiadomość',
            ));
        }
        
        $objMessage
                ->setReply($request->get('content'))
                ->setStatus(\DataBundle\Entity\Message::STATUS_REPLY);
        $em->flush();
        
        $this->sendEmailUsers(array($objMessage->getGuardUser()), 'epozyczki.pl - odpowiedź na wiadomość', $this->renderView('AcmeGlobalBundle:Email:sendReply.html.twig', array(
            'user' => $objMessage->getGuardUser(),
            'from' => $this->getUser(),
            'credit' => $objMessage->getCredit(),
        )));
        
        return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                    'status' => 'success',
                    'message' => 'Odpowiedziałeś na wiadomość',
        ));
        
    }
    
    

}
