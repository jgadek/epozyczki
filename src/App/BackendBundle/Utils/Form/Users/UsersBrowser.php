<?php

namespace App\BackendBundle\Utils\Form\Users;

use Symfony\Component\HttpFoundation\Request;
use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\Browser;
use Doctrine\ORM\EntityManager;

class UsersBrowser extends Browser
{

    public function __construct(Request $request, GuardUser $objUser, EntityManager $em)
    {
        parent::__construct($request, $objUser, $em);
        
        $this->setSortForm(new UsersSortForm($this->getOrder(), $this->getDir()));
        $this->setFilterForm(new UsersFilterForm($this->getFieldsArray()));

        $this->generateQuery("
                SELECT gu
                    FROM AppGuardBundle:GuardUser gu
        ");
        
        
        $objFilterForm = $this->getFilterForm();
        
        if ($objFilterForm->hasId()) {
            $this->addContidion("gu.id = " . $objFilterForm->getId());
        }
        
        if ($objFilterForm->hasUsername()) {
            $this->addContidion("gu.username like '%" . $objFilterForm->getUsername() . "%'");
        }
        $this->generateResult();
    }
    
    public function getLimit()
    {
        return GuardUser::DEFAULT_LIMIT_ADMIN_LIST;
    }

}
