<?php

namespace App\FrontendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Acme\GlobalBundle\Controller\BaseController;

class FrontendController extends BaseController
{

    /**
     * 
     * @param \App\GuardBundle\Entity\GuardUser $objUser
     */
    public function sendEmailRegister(\App\GuardBundle\Entity\GuardUser $objUser)
    {
        if (null === $objUser->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->get('fos_user.util.token_generator');
            $objUser->setConfirmationToken($tokenGenerator->generateToken());
        }

        $url = $this->generateUrl('acme_global_email_registerConfirm', array(
            'token' => $objUser->getConfirmationToken(),
                ), true);

        $view = $this->renderView('AcmeGlobalBundle:Email:register.html.twig', array(
            'url' => $url
        ));
        $this->sendEmailUsers($objUser, 'e-pozyczki.pl - rejestracja', $view);

        $this->getDoctrine()->getManager()->flush();
    }

}
