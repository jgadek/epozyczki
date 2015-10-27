<?php

namespace App\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends FOSRestController
{

    protected $apiEvent;

    public function initialize(Request $request)
    {
        $this->apiEvent = new \App\ApiBundle\Utils\ApiEvent();
        $this->getApiEvent()->setApiKey($this->getParameter('api_key'));
    }

    public function checkApiKey(Request $request)
    {
        if($this->getApiEvent()->checkApiKey($request->get('api_key'))) {
            return true;
        }
        $this->setHttpStatus(Response::HTTP_FORBIDDEN);
        $this->setData('Bad api key');
    }

    /**
     * 
     * @return \App\ApiBundle\Utils\ApiEvent
     */
    public function getApiEvent()
    {
        return $this->apiEvent;
    }

    public function send()
    {
        $view = $this->view($this->getData(), $this->getHttpStatus());
        return $this->handleView($view);
    }

    public function getData()
    {
        return $this->getApiEvent()->getData();
    }

    public function setData($data)
    {
        $this->getApiEvent()->setData($data);
    }

    public function appendToData($data)
    {
        $this->getApiEvent()->appendToData($data);
    }

    public function setHttpStatus($status)
    {
        $this->getApiEvent()->setHttpStatus($status);
    }
    
    public function getHttpStatus()
    {
        return $this->getApiEvent()->getHttpStatus();
    }

}
