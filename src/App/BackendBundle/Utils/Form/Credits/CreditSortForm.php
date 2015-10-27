<?php

namespace App\BackendBundle\Utils\Form\Credits;
use Acme\Utils\Form\SortForm;

class CreditSortForm extends SortForm
{
    public function getArrayFields()
    {
        return array(
            'created_at' => 'Data utworzenia',
            'references' => 'ID wniosku'
        );
    }
    
    public function getArrayDatabaseFields()
    {
        return array(
            'created_at' => 'c.createdAt',
            'references' => 'c.references'
        );
    }

}
