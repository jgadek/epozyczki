<?php

namespace App\FrontendBundle\Utils\Form\LenderDashboard;

use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\Browser;

class LenderDashboardBrowser extends Browser
{
    
    
    public function __construct(\Symfony\Component\HttpFoundation\Request $request, GuardUser $objUser, \Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($request, $objUser, $em);
        $this->setFilterForm(new LenderDashboardFilterForm($this->getFieldsArray()));
        $this->setSortForm(new LenderDashboardSortForm($this->getOrder(), $this->getDir()));
        
        $this->generateQuery("
                SELECT c
                    FROM DataBundle:Credit c
        ");
        
        
        $objFilterForm = $this->getFilterForm();

        $preferedCreditAmountFrom = $objUser->getLenderAmountFrom();
        $preferedCreditAmountTo = $objUser->getLenderAmountTo();
        $preferedReplaymentFrom = $objUser->getLenderReplaymentTimeForm();
        $preferedReplaymentTo = $objUser->getLenderReplaymentTimeTo();
        
        $this->addContidion("(c.creditAmount >= " . $preferedCreditAmountFrom . " AND c.creditAmount <= " . $preferedCreditAmountTo . " )");
        $this->addContidion("(c.replaymentTime >= " . $preferedReplaymentFrom . " AND c.replaymentTime <= " . $preferedReplaymentTo . " )");

        $this->addContidion("(c.status = " . \DataBundle\Entity\Credit::STATUS_ADMIN_ACCEPTED . " OR c.lender = ".$objUser->getId().")");
        
        if ($objFilterForm->hasCreatedAt()) {
            $dt = new \DateTime($objFilterForm->getCreatedAt());
            $this->addContidion("c.createdAt > '" . $dt->format('Y-m-d') ." 00:00:00' AND c.createdAt < '". $dt->format('Y-m-d') ." 23:59:59'");
        }
        
        if ($objFilterForm->hasReferences()) {
            $this->addContidion("c.references = '" . $objFilterForm->getReferences() . "'");
        }

        $this->generateResult();
    }
    
    
    
    public function getLimit()
    {
        return \DataBundle\Entity\Credit::DEFAULT_LIMIT_LENDER_DASHBOARD;
    }

}
