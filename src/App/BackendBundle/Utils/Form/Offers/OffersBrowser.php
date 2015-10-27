<?php

namespace App\BackendBundle\Utils\Form\Offers;

use Symfony\Component\HttpFoundation\Request;
use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\Browser;
use Doctrine\ORM\EntityManager;

class OffersBrowser extends Browser
{

    public function __construct(Request $request, GuardUser $objUser, EntityManager $em)
    {
        parent::__construct($request, $objUser, $em);

        $this->setSortForm(new OffersSortForm($this->getOrder(), $this->getDir()));
        $this->setFilterForm(new OffersFilterForm($this->getFieldsArray()));

        $this->generateQuery("
                SELECT o
                    FROM DataBundle:Offer o
        ");
        
        
        $objFilterForm = $this->getFilterForm();
        $objSortForm = $this->getSortForm();
        
        if ($objFilterForm->hasCreatedAt()) {
            $dt = new \DateTime($objFilterForm->getCreatedAt());
            $this->addContidion("o.createdAt > '" . $dt->format('Y-m-d') ." 00:00:00' AND o.createdAt < '". $dt->format('Y-m-d') ." 23:59:59'");
        }
        
        if ($objFilterForm->hasReferences()) {
            $this->addContidion("o.references = " . $objFilterForm->getId());
        }
        
        if ($objFilterForm->hasStatus()) {
            $this->addContidion("o.status = " . $objFilterForm->getStatus());
        }
        
        $this->generateResult();
    }
    
    public function getLimit()
    {
        return \DataBundle\Entity\Offer::DEFAULT_LIMIT_OFFER_ADMIN_LIST;
    }

}
