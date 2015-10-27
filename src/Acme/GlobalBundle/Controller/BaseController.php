<?php

namespace Acme\GlobalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\GuardBundle\Entity\GuardUser;

class BaseController extends Controller
{

    /**
     * Zapisanie do sesji obiektu CreditCreator
     * @param type $strSerialized
     */
    public function saveCreditCreator($strSerialized)
    {
        $this->get('session')->set('CreditCreator', $strSerialized);
    }

    /**
     * Usuwanie z sesji obiektu CreditCreator
     */
    public function removeCreditCreator()
    {
        $this->get('session')->set('CreditCreator', null);
    }

    /**
     * Pobranie z sesji obiektu CreditCreator
     * @return \App\FrontendBundle\Utils\Session\CreditCreator
     */
    public function getCreditCreator()
    {

        $strSerialized = $this->get('session')->get('CreditCreator');
        if ($strSerialized === null && ($this->getUser() instanceof \App\GuardBundle\Entity\GuardUser)) {
            $objCreditCreator = new \App\FrontendBundle\Utils\Session\CreditCreator();
            $objCreditCreator->setUserData($this->getUser());
            $this->saveCreditCreator(serialize($objCreditCreator));
            return $objCreditCreator;
        }
        return \App\FrontendBundle\Utils\Session\CreditCreator::unserialized($strSerialized);
    }

    /**
     * Zapisanie do sesji obiektu LenderCreator
     * @param type $strSerialized
     */
    public function saveLenderCreator($strSerialized)
    {
        $this->get('session')->set('LenderCreator', $strSerialized);
    }

    /**
     * Usuwanie z sesji obiektu LenderCreator
     */
    public function removeLenderCreator()
    {
        $this->get('session')->set('LenderCreator', null);
    }

    /**
     * Pobranie z sesji obiektu LenderCreator
     * @return \App\FrontendBundle\Utils\Session\LenderCreator
     */
    public function getLenderCreator()
    {

        $strSerialized = $this->get('session')->get('LenderCreator');
        return \App\FrontendBundle\Utils\Session\LenderCreator::unserialized($strSerialized);
    }

    public function afterLoginAction(Request $request)
    {
        $objUser = $this->getUser();

        if ($objUser->hasRole(GuardUser::ROLE_BORROWER)) {
            $this->removeCreditCreator();
        }

        return $this->getRedirectDashboard();
    }

    public function redirectUserPanelAction(Request $request)
    {
        return $this->getRedirectDashboard();
    }

    public function getRedirectDashboard()
    {
        $objUser = $this->getUser();
        if (!$objUser instanceof GuardUser) {
            return $this->redirect($this->generateUrl('app_frontend_main_index'));
        }

        if ($objUser->hasRole(GuardUser::ROLE_BORROWER)) {
            return $this->redirect($this->generateUrl('app_frontend_borrower_myApplications'));
        }

        if ($objUser->hasRole(GuardUser::ROLE_LENDER)) {
            return $this->redirect($this->generateUrl('app_frontend_lender_dashboard_index'));
        }

        if ($objUser->hasRole(GuardUser::ROLE_ADMIN) || $objUser->hasRole(GuardUser::ROLE_SUPER_ADMIN)) {
            return $this->redirect($this->generateUrl('app_backend_main_index'));
        }

        return $this->redirect($this->generateUrl('app_frontend_main_index'));
    }

    public function ajaxError(Request $request)
    {
        return $this->render('AcmeGlobalBundle:Base:ajaxError.html.twig', array(
                    'message' => $request->get('message')
        ));
    }

    public function generateUrlAjaxForBrowserAction(Request $request)
    {
        $url = $this->generateUrl($request->get('route'), array(
            'page' => $request->get('page'),
            'order' => $request->get('order'),
            'dir' => $request->get('dir'),
            'fields' => $request->get('fields'),
        ));
        return new \Symfony\Component\HttpFoundation\JsonResponse(array('url' => $url));
    }

    public function formValidAjaxAction(Request $request)
    {
        $class = '\\' . json_decode($request->get('form_class'));
        $objForm = new $class();
        $form = $this->createForm($objForm);
        $form->handleRequest($request);
        if ($form->isValid()) {
            return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                        'status' => 'success'
            ));
        }
        $arrErrors = $form->getErrors();
        return \Symfony\Component\HttpFoundation\JsonResponse::create(array(
                    'status' => 'error',
                    'errors' => $arrErrors,
        ));
    }

    public function sendEmailUsers($collUsers, $subject, $body)
    {
        $send = FALSE;
        $collUsers = is_array($collUsers) ? $collUsers : array($collUsers);
        if ($this->container->hasParameter('mailer_available') && $this->container->getParameter('mailer_available') === TRUE) {
            $arrTo = array();
            foreach ($collUsers as $objUser) {
                /* @var $objUser GuardUser  */
                if ($objUser instanceof GuardUser) {
                    $arrTo[] = $objUser->getEmail();
                } else {
                    $arrTo[] = $objUser;
                }
            }
            $from = array($this->container->getParameter('mailer_user') => 'epozyczki.pl');
            $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($from)
                    ->setTo($arrTo)
                    ->setBody($body)
                    ->setContentType("text/html");
            $send = $this->get('mailer')->send($message);
        }
        return $send ? TRUE : FALSE;
    }

    public function sendEmailAdmin($subject, $body)
    {
        $send = FALSE;
        if ($this->container->hasParameter('mailer_available') && $this->container->getParameter('mailer_available') === TRUE && $this->container->hasParameter('mailer_admin_list')) {
            $arrAdmins = $this->container->getParameter('mailer_admin_list');
            $arrTo = array();
            $arrTo = explode(',', $arrAdmins['admin']);
            $from = array($this->container->getParameter('mailer_user') => 'epozyczki.pl');
            foreach ($arrTo as $to) {
                $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($from)
                        ->setTo($to)
                        ->setBody($body)
                        ->setContentType("text/html");
                $send = $this->get('mailer')->send($message);
            }
        }
        return $send ? TRUE : FALSE;
    }

    public function isWriteableCredit(\DataBundle\Entity\Credit $objCredit)
    {
        if ($objCredit->getGuardUser() !== $this->getUser()) {
            return false;
        }
        return true;
    }

}
