<?php

namespace App\FrontendBundle\Controller;

use App\FrontendBundle\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;

class MainController extends FrontendController
{

    /**
     * EXAMPLE CALL TO REST API
      $caller = $this->get('api_caller');
      $url = $this->generateUrl('get_user', array('id' => 1), true);
      $objHttp = new \Lsw\ApiCallerBundle\Call\HttpGetJson($url, array());
      $data = $caller->call($objHttp);
      $code = $objHttp->getStatusCode();
     */
    public function indexAction(Request $request)
    {
        $objForm = new \App\FrontendBundle\Utils\Form\Credit\FirstStepCreditForm($this->getCreditCreator(), $this->getUser());
        $form = $this->createForm($objForm);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $objForm->save($form->getData());
            $this->saveCreditCreator($objForm->getCreditCreator()->serialize());
            return $this->redirect($this->generateUrl("app_frontend_credit_secondStep"));
        }
        return $this->render('AppFrontendBundle:Main:index.html.twig', array(
                    'form' => $form->createView(),
                    'last_credits' => $this->getDoctrine()->getManager()->getRepository("DataBundle:Credit")
                            ->findBy(array(
                                'status' => \DataBundle\Entity\Credit::STATUS_ADMIN_ACCEPTED,
                            ), array(
                                'id' => 'DESC'
                            ))
        ));
    }

}
