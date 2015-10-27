<?php

namespace App\GuardBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppGuardBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
