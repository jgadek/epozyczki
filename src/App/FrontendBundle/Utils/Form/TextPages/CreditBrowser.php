<?php

namespace App\FrontendBundle\Utils\Form\TextPages;

use App\GuardBundle\Entity\GuardUser;
use Acme\Utils\Browser;

class CreditBrowser extends Browser
{

    public function __construct(\Symfony\Component\HttpFoundation\Request $request, GuardUser $objUser = null, \Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($request, $objUser, $em);
        $this->setFilterForm(new CreditFilterForm($this->getFieldsArray()));
        $this->setSortForm(new CreditSortForm($this->getOrder(), $this->getDir()));

        $this->generateQuery("
                SELECT c
                    FROM DataBundle:Credit c
        ");


        $objFilterForm = $this->getFilterForm();

        $this->addContidion("c.status = " . \DataBundle\Entity\Credit::STATUS_ADMIN_ACCEPTED);

        if ($objFilterForm->hasCreatedAt()) {
            $dt = new \DateTime($objFilterForm->getCreatedAt());
            $this->addContidion("c.createdAt > '" . $dt->format('Y-m-d') . " 00:00:00' AND c.createdAt < '" . $dt->format('Y-m-d') . " 23:59:59'");
        }

        if ($objFilterForm->hasReferences()) {
            $this->addContidion("c.references = '" . $objFilterForm->getReferences() . "'");
        }

        $this->generateResult();
    }

    public function getLimit()
    {
        return \DataBundle\Entity\Credit::DEFAULT_LIMIT_CREDITS_LIST;
    }

}
