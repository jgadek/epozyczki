<?php

namespace App\BackendBundle\Utils\Form\Credits;

use Symfony\Component\HttpFoundation\Request;
use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\Browser;
use Doctrine\ORM\EntityManager;

class CreditBrowser extends Browser
{

    public function __construct(Request $request, GuardUser $objUser, EntityManager $em)
    {
        parent::__construct($request, $objUser, $em);

        $this->setSortForm(new CreditSortForm($this->getOrder(), $this->getDir()));
        $this->setFilterForm(new CreditFilterForm($this->getFieldsArray()));

        $this->generateQuery("
                SELECT c
                    FROM DataBundle:Credit c
        ");
        
        
        $objFilterForm = $this->getFilterForm();
        $objSortForm = $this->getSortForm();
        
        if ($objFilterForm->hasCreatedAt()) {
            $dt = new \DateTime($objFilterForm->getCreatedAt());
            $this->addContidion("c.createdAt > '" . $dt->format('Y-m-d') ." 00:00:00' AND c.createdAt < '". $dt->format('Y-m-d') ." 23:59:59'");
        }
        
        if ($objFilterForm->hasReferences()) {
            $this->addContidion("c.references = '" . $objFilterForm->getReferences() . "'");
        }
        
        if ($objFilterForm->hasStatus()) {
            $this->addContidion("c.status = " . $objFilterForm->getStatus());
        }
        
        $this->generateResult();
    }
    
    public function getLimit()
    {
        return \DataBundle\Entity\Credit::DEFAULT_LIMIT_ADMIN_LIST;
    }

}
