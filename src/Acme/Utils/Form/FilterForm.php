<?php

namespace Acme\Utils\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class FilterForm extends AbstractType
{

    private $arrValues = array();
    private $variables;

    public function __construct($arrValues = array())
    {
        $this->variables = new \stdClass();
        foreach ($this->getAvailableFields() as $key => $value) {
            $key = preg_replace_callback('/_./', function ($matches) {
                return strtoupper(str_replace('_', '', $matches[0]));
            }, $key);
            $this->variables->$key = $value;
        }
        foreach ($arrValues as $key => $value) {
            $key = preg_replace_callback('/_./', function ($matches) {
                return strtoupper(str_replace('_', '', $matches[0]));
            }, $key);
            if(property_exists($this->variables, $key)) {
                $this->variables->$key = $value;
            }
        }
        
    }

    public function getInfoField($key)
    {
        $arrFields = $this->getInfoFields();
        if(!is_array($arrFields)) {
            return null;
        }
        if (key_exists($key, $arrFields)) {
            return $arrFields[$key];
        }
    }

    public function __call($name, $arguments)
    {
        if (preg_match('/^get/', $name) && !method_exists($this, $name)) {
            $variable = lcfirst(preg_replace('/^get/', '', $name));
            return $this->variables->$variable;
        }

        if (preg_match('/^set/', $name) && !method_exists($this, $name)) {
            $variable = lcfirst(preg_replace('/^set/', '', $name));
            $this->variables->$variable = $arguments[0];
        }

        if (preg_match('/^has/', $name) && !method_exists($this, $name)) {
            $variable = lcfirst(preg_replace('/^has/', '', $name));
            return ($this->variables->$variable !== null && $this->variables->$variable !== '');
        }
    }

    public function getName()
    {
        return 'filter_form';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    public function getClassName()
    {
        return json_encode(get_class($this));
    }

    abstract function getAvailableFields();
    abstract function getInfoFields();
}
