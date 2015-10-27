<?php

namespace App\BackendBundle\Controller;

use App\BackendBundle\Controller\BackendController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends BackendController
{

    public function indexAction(Request $request)
    {
        return $this->render('AppBackendBundle:Main:index.html.twig', array(
        ));
    }

}
