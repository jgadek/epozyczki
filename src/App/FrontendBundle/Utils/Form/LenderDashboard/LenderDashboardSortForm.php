<?php

namespace App\FrontendBundle\Utils\Form\LenderDashboard;

use Acme\Utils\Form\SortForm;

class LenderDashboardSortForm extends SortForm
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
