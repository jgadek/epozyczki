<?php

namespace App\BackendBundle\Controller;

use App\BackendBundle\Controller\BackendController;
use Symfony\Component\HttpFoundation\Request;

class LoanController extends BackendController
{

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objBrowser = new \App\BackendBundle\Utils\Form\Loan\LoanBrowser($request, $this->getUser(), $em);

        $template = $request->isXmlHttpRequest() ? 'AppBackendBundle:Loan:listAjax.html.twig' : 'AppBackendBundle:Loan:list.html.twig';

        return $this->render($template, array(
                    'sort_form' => $this->createForm($objBrowser->getSortForm())->createView(),
                    'filter_form' => $this->createForm($objBrowser->getFilterForm())->createView(),
                    'browser' => $objBrowser,
        ));
    }
    
    public function setStatusAjaxAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objLoan = $em->getRepository('DataBundle:Loan')->find($request->get('id'));

        $status = (int) $request->get('status');
        /* @var $objLoan \DataBundle\Entity\Loan */
        $objLoan->setStatus($status);
        $em->flush();

        return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                    'status' => 'success',
                    'new_status_label' => $objLoan->getStatusLabel(),
                    'message' => 'Pożyczka o ID równym ' . $objLoan->getId() . ' zmieniła status na ' . $objLoan->getStatusLabel()
        ));
    }

}
