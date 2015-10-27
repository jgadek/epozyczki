<?php

namespace App\FrontendBundle\Controller;

use App\FrontendBundle\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;

class TextPagesController extends FrontendController
{
    public function aboutAction(Request $request)
    {
        return $this->render('AppFrontendBundle:TextPages:about.html.twig');
    }
    
    public function contactAction(Request $request)
    {
        return $this->render('AppFrontendBundle:TextPages:contact.html.twig');
    }
    
    public function regulationsAction(Request $request)
    {
        return $this->render('AppFrontendBundle:TextPages:regulations.html.twig');
    }
    
    public function moreAboutSecurityAction(Request $request)
    {
        return $this->render('AppFrontendBundle:TextPages:moreAboutSecurity.html.twig');
    }
    
    public function creditsListAction(Request $request)
    {
        $objBrowser = new \App\FrontendBundle\Utils\Form\TextPages\CreditBrowser($request, $this->getUser(), $this->getDoctrine()->getManager());

        $template = $request->isXmlHttpRequest() ? 'AppFrontendBundle:TextPages:creditsListAjax.html.twig' : 'AppFrontendBundle:TextPages:creditsList.html.twig';

        return $this->render($template, array(
                    'sort_form' => $this->createForm($objBrowser->getSortForm())->createView(),
                    'filter_form' => $this->createForm($objBrowser->getFilterForm())->createView(),
                    'browser' => $objBrowser,
        ));
    }
}
