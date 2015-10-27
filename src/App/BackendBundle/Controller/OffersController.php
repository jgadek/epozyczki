<?php

namespace App\BackendBundle\Controller;

use App\BackendBundle\Controller\BackendController;
use Symfony\Component\HttpFoundation\Request;

class OffersController extends BackendController
{

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $objBrowser = new \App\BackendBundle\Utils\Form\Offers\OffersBrowser($request, $this->getUser(), $em);

        $template = $request->isXmlHttpRequest() ? 'AppBackendBundle:Offers:listAjax.html.twig' : 'AppBackendBundle:Offers:list.html.twig';

        return $this->render($template, array(
                    'sort_form' => $this->createForm($objBrowser->getSortForm())->createView(),
                    'filter_form' => $this->createForm($objBrowser->getFilterForm())->createView(),
                    'browser' => $objBrowser,
        ));
    }
}
