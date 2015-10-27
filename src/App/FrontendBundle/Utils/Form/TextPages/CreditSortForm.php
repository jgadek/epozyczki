<?php

namespace App\FrontendBundle\Utils\Form\TextPages;

class CreditSortForm extends \Acme\Utils\Form\SortForm
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
