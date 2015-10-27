<?php

namespace App\BackendBundle\Utils\Form\Loan;

use Symfony\Component\HttpFoundation\Request;
use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\Browser;
use Doctrine\ORM\EntityManager;

class LoanBrowser extends Browser
{

    public function __construct(Request $request, GuardUser $objUser, EntityManager $em)
    {
        parent::__construct($request, $objUser, $em);

        $this->setSortForm(new LoanSortForm($this->getOrder(), $this->getDir()));
        $this->setFilterForm(new LoanFilterForm($this->getFieldsArray()));

        $this->generateQuery("
                SELECT l
                    FROM DataBundle:Loan l
        ");
        
        
        $objFilterForm = $this->getFilterForm();
        $objSortForm = $this->getSortForm();
        
        if ($objFilterForm->hasCreatedAt()) {
            $dt = new \DateTime($objFilterForm->getCreatedAt());
            $this->addContidion("l.createdAt > '" . $dt->format('Y-m-d') ." 00:00:00' AND l.createdAt < '". $dt->format('Y-m-d') ." 23:59:59'");
        }
        
        if ($objFilterForm->hasId()) {
            $this->addContidion("l.id = " . $objFilterForm->getId());
        }
        
        if ($objFilterForm->hasStatus()) {
            $this->addContidion("l.status = " . $objFilterForm->getStatus());
        }
        
        $this->generateResult();
    }
    
    public function getLimit()
    {
        return \DataBundle\Entity\Loan::DEFAULT_LIMIT_LOAN_ADMIN_LIST;
    }

}
