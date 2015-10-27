<?php

namespace App\BackendBundle\Utils\Form\Loan;

use Acme\Utils\Form\FilterForm;

class LoanFilterForm extends FilterForm
{

    protected static $arrDatabase = array(
        'id' => '',
        'created_at' => '',
        'status' => '',
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

        $builder->add('id', 'text', array(
            'attr' => array(
                'placeholder' => 'ID Pożyczki',
                'pattern' => '\d+',
            ),
            'data' => $this->getId(),
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
        
        $builder->add('status', 'choice', array(
            'choices' => \DataBundle\Entity\Loan::GetStatuses(),
            'placeholder' => 'Wybierz status',
            'required' => false,
            'data' => $this->getStatus(),
            'attr' => array(
                'pattern' => '\d+',
            ),
        ));
    }

}
