<?php

namespace App\BackendBundle\Controller;

use App\BackendBundle\Controller\BackendController;
use Symfony\Component\HttpFoundation\Request;

class CreditsController extends BackendController
{

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objBrowser = new \App\BackendBundle\Utils\Form\Credits\CreditBrowser($request, $this->getUser(), $em);

        $template = $request->isXmlHttpRequest() ? 'AppBackendBundle:Credits:listAjax.html.twig' : 'AppBackendBundle:Credits:list.html.twig';

        return $this->render($template, array(
                    'sort_form' => $this->createForm($objBrowser->getSortForm())->createView(),
                    'filter_form' => $this->createForm($objBrowser->getFilterForm())->createView(),
                    'browser' => $objBrowser,
        ));
    }

    public function setStatusAjaxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objCredit = $em->getRepository('DataBundle:Credit')->find($request->get('creditID'));

        $status = (int) $request->get('status');
        /* @var $objCredit \DataBundle\Entity\Credit */
        $objCredit->setStatus($status);

        if ($status === \DataBundle\Entity\Credit::STATUS_SECOND_ADMIN_ACCEPTED) {
            $objLoan = new \DataBundle\Entity\Loan();
            $objLoan->setCredit($objCredit);
            $em->persist($objLoan);
            $objCredit->setLoan($objLoan);
        }
        $em->flush();

        $this->sendMessagesByStatusAndCredit($objCredit, $status);

        return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                    'status' => 'success',
                    'new_status_label' => $objCredit->getStatusLabel(),
                    'message' => 'Wniosek o ID równym ' . $objCredit->getReferences() . ' zmienił status na ' . $objCredit->getStatusLabel()
        ));
    }

    public function sendMessagesByStatusAndCredit(\DataBundle\Entity\Credit $objCredit, $status)
    {
        if ($status === \DataBundle\Entity\Credit::STATUS_ADMIN_ACCEPTED) {
            $view = 'AcmeGlobalBundle:Email:adminAccepted.html.twig';
            $this->sendEmailUsers($objCredit->getGuardUser(), 'epozyczki.pl - wniosek zaakceptowany', $this->renderView($view, array(
                        'user' => $objCredit->getGuardUser(),
                        'credit' => $objCredit
            )));
        }

        if ($status === \DataBundle\Entity\Credit::STATUS_ADMIN_REJECTED) {
            $view = 'AcmeGlobalBundle:Email:adminRejected.html.twig';
            $this->sendEmailUsers($objCredit->getGuardUser(), 'epozyczki.pl - wniosek odrzucony', $this->renderView($view, array(
                        'user' => $objCredit->getGuardUser(),
                        'credit' => $objCredit
            )));
        }

        if ($status === \DataBundle\Entity\Credit::STATUS_SECOND_ADMIN_ACCEPTED) {
            $view = 'AcmeGlobalBundle:Email:adminAcceptedSecondBorrower.html.twig';
            $this->sendEmailUsers($objCredit->getGuardUser(), 'epozyczki.pl - wniosek zaakceptowany', $this->renderView($view, array(
                        'user' => $objCredit->getGuardUser(),
                        'credit' => $objCredit
            )));
            $view = 'AcmeGlobalBundle:Email:adminAcceptedSecondLender.html.twig';
            $this->sendEmailUsers($objCredit->getLender(), 'epozyczki.pl - wniosek zaakceptowany', $this->renderView($view, array(
                        'user' => $objCredit->getLender(),
                        'credit' => $objCredit
            )));
        }

        if ($status === \DataBundle\Entity\Credit::STATUS_SECOND_ADMIN_REJECTED) {
            $view = 'AcmeGlobalBundle:Email:adminRejectedSecondBorrower.html.twig';
            $this->sendEmailUsers($objCredit->getGuardUser(), 'epozyczki.pl - wniosek odrzucony', $this->renderView($view, array(
                        'user' => $objCredit->getGuardUser(),
                        'credit' => $objCredit
            )));
            $view = 'AcmeGlobalBundle:Email:adminRejectedSecondLender.html.twig';
            $this->sendEmailUsers($objCredit->getLender(), 'epozyczki.pl - wniosek odrzucony', $this->renderView($view, array(
                        'user' => $objCredit->getLender(),
                        'credit' => $objCredit
            )));
        }
    }

}
