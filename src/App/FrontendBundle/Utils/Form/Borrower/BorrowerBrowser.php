<?php

namespace App\FrontendBundle\Utils\Form\Borrower;

use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\Browser;

class BorrowerBrowser extends Browser
{
    
    
    public function __construct(\Symfony\Component\HttpFoundation\Request $request, GuardUser $objUser, \Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($request, $objUser, $em);
        $this->setFilterForm(new BorrowerFilterForm($this->getFieldsArray()));
        $this->setSortForm(new BorrowerSortForm($this->getOrder(), $this->getDir()));
        
        $this->generateQuery("
                SELECT c
                    FROM DataBundle:Credit c
        ");
        
        
        $objFilterForm = $this->getFilterForm();
        
        $this->addContidion("c.guardUser = " . $objUser->getId());
        $this->addContidion("c.status not in (" . join(',', \DataBundle\Entity\Credit::GetStatusesHidden()) . ")");
        
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
        return \DataBundle\Entity\Credit::DEFAULT_LIMIT_BORROWER;
    }

}
