<?php

namespace App\BackendBundle\Utils\Form\Loan;
use Acme\Utils\Form\SortForm;

class LoanSortForm extends SortForm
{
    public function getArrayFields()
    {
        return array(
            'created_at' => 'Data utworzenia',
            'id' => 'ID pożyczki'
        );
    }
    
    public function getArrayDatabaseFields()
    {
        return array(
            'created_at' => 'l.createdAt',
            'id' => 'l.id'
        );
    }

}
