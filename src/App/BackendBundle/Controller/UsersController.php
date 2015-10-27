<?php

namespace App\BackendBundle\Controller;

use App\BackendBundle\Controller\BackendController;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends BackendController
{
    public function listAction(Request $request)
    {
        
        $objBrowser = new \App\BackendBundle\Utils\Form\Users\UsersBrowser($request, $this->getUser(), $this->getDoctrine()->getManager());
        
        $template = $request->isXmlHttpRequest() ? 'AppBackendBundle:Users:listAjax.html.twig' : 'AppBackendBundle:Users:list.html.twig';
        
        return $this->render($template, array(
            'sort_form' => $this->createForm($objBrowser->getSortForm())->createView(),
            'filter_form' => $this->createForm($objBrowser->getFilterForm())->createView(),
            'browser' => $objBrowser,
        ));
    }
    
}
