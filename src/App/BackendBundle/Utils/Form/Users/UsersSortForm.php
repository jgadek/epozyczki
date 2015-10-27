<?php

namespace App\BackendBundle\Utils\Form\Users;
use Acme\Utils\Form\SortForm;

class UsersSortForm extends SortForm
{
    public function getArrayFields()
    {
        return array(
            'id' => 'ID użytkownika',
            'username' => 'Nazwa użytkownika',
        );
    }
    
    public function getArrayDatabaseFields()
    {
        return array(
            'id' => 'gu.id',
            'username' => 'gu.username'
        );
    }

}
