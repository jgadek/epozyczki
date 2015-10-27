<?php

namespace App\FrontendBundle\Utils\Form\LenderDashboard;

use Acme\Utils\Form\FilterForm;

class LenderDashboardFilterForm extends FilterForm
{

    protected static $arrDatabase = array(
        'references' => '',
        'created_at' => '',
    );
    
    protected static $arrInfo = array(
        'created_at' => 'Proszę podać datę w formacie dd.mm.yyyy',
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

        $builder->add('references', 'text', array(
            'attr' => array(
                'placeholder' => 'ID Wniosku',
                'pattern' => '\d+',
            ),
            'data' => $this->getReferences(),
            'required' => false,
        ));

        $builder->add('created_at', 'text', array(
            'attr' => array(
                'placeholder' => 'Data utworzenia',
                'pattern' => '\d{2}.\d{2}.\d{4}',
            ),
            'data' => $this->getCreatedAt(),
            'required' => false,
        ));
    }

}
