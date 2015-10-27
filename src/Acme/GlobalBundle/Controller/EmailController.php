<?php

namespace Acme\GlobalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\GuardBundle\Entity\GuardUser;
use Acme\GlobalBundle\Controller\BaseController;

class EmailController extends BaseController
{

    public function registerConfirmAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $token = $request->get('token');
        /* @var $objUser GuardUser */
        $objUser = $em->getRepository("AppGuardBundle:GuardUser")->findOneBy(array(
            'enabled' => false,
            'confirmationToken' => $token
        ));

        if (!($objUser instanceof GuardUser)) {
            return new \Symfony\Component\HttpFoundation\Response('Link wygasł', 404);
        }

        $objUser->setEnabled(true);
        $objUser->setConfirmationToken(null);
        $em->getRepository('DataBundle:Credit')->activeCreditsByUser($objUser);
        $em->flush();
        $this->get('session')->getFlashbag()->set('success', 'Konto zostało aktywowane');
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

    public function testEmailAction(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
//        $objCredit = $em->getRepository('DataBundle:Credit')->find(9);
//        $view = 'TEST';

        $send = $this->sendEmailAdmin('spam', 'spam');
        var_dump($send); die;
        return $this->render("AcmeGlobalBundle:Email:test.html.twig");
    }

}
