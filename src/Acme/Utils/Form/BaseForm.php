<?php

namespace Acme\Utils\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class BaseForm extends AbstractType
{

    abstract function getName();

}
