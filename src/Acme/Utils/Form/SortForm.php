<?php

namespace Acme\Utils\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class SortForm extends AbstractType
{

    CONST DIR_ASC = 'ASC';
    CONST DIR_DESC = 'DESC';

    public static $arrDir = array(
        self::DIR_ASC => 'Rosnąco',
        self::DIR_DESC => 'Malejąco',
    );
    private $order;
    private $dir;

    public function __construct($order, $dir)
    {
        $this->order = $order;
        $this->dir = $dir;
    }

    public function getName()
    {
        return 'sort_form';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('dir', 'choice', array(
            'choices' => self::$arrDir,
            'required' => TRUE,
            'data' => $this->dir,
        ));

        $builder->add('fields', 'choice', array(
            'choices' => $this->getArrayFields(),
            'required' => TRUE,
            'data' => $this->order,
        ));
    }

    abstract function getArrayFields();

    abstract function getArrayDatabaseFields();
    
    public function getOrderToQuery()
    {
        $arrFields = $this->getArrayDatabaseFields();
        return $arrFields[$this->order];
    }

    public function getSortToQuery()
    {
        return $this->getOrderToQuery() . ' ' . $this->dir;
    }

}
