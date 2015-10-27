<?php

namespace App\ApiBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use App\ApiBundle\Controller\ApiController;

class ApiKeyControllerListener
{

    public function __construct()
    {
    }
    
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        if (!is_array($controller)) {
            return;
        }
        if ($controller[0] instanceof ApiController) {
            $controller[0]->initialize($event->getRequest());
            $controller[0]->checkApiKey($event->getRequest());
        }
    }

}
