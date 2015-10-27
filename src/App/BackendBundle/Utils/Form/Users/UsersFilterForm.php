<?php

namespace App\BackendBundle\Utils\Form\Users;

use Acme\Utils\Form\FilterForm;

class UsersFilterForm extends FilterForm
{

    protected static $arrDatabase = array(
        'id' => '',
        'username' => ''
    );
    
    protected static $arrInfo = array(
    );

    public function getAvailableFields()
    {
        return self::$arrDatabase;
    }
    
    public function getInfoFields()
    {
        return self::$arrInfo;
    }

    public function __construct($arrValues = array())
    {
        parent::__construct($arrValues);
    }

    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('id', 'text', array(
            'attr' => array(
                'placeholder' => 'ID użytkownika',
            ),
            'data' => $this->getId(),
            'required' => false,
        ));

        $builder->add('username', 'text', array(
            'attr' => array(
                'placeholder' => 'Nazwa użytkownika',
            ),
            'data' => $this->getUsername(),
            'required' => false,
        ));
    }

}
