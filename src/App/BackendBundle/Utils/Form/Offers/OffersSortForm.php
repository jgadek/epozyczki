<?php

namespace App\BackendBundle\Utils\Form\Offers;
use Acme\Utils\Form\SortForm;

class OffersSortForm extends SortForm
{
    public function getArrayFields()
    {
        return array(
            'created_at' => 'Data utworzenia',
            'references' => 'ID oferty'
        );
    }
    
    public function getArrayDatabaseFields()
    {
        return array(
            'created_at' => 'o.createdAt',
            'references' => 'o.references'
        );
    }

}
