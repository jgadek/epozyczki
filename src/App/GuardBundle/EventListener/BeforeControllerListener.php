<?php

namespace App\GuardBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use App\GuardBundle\Controller\GuardController;

class BeforeControllerListener
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
        if ($controller[0] instanceof GuardController) {
            $controller[0]->preExecute($event->getRequest());
        }
    }

}
