<?php

namespace App\FrontendBundle\Utils\Form\Borrower;

use Acme\Utils\Form\SortForm;

class BorrowerSortForm extends SortForm
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
