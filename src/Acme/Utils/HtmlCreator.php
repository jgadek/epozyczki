<?php

namespace Acme\Utils;

class HtmlCreator
{
    public static function CreateSelect($array = array(), $class = '', $id = '', $selected = null)
    {
        $string = '<select class="'.$class.'" id="'.$id.'" >';
        foreach ($array as $key => $value)
        {
            $string .= '<option value="'.$key.'" '.($key === $selected ? 'selected' : '').'>'.$value.'</option>';
        }
        $string .= '</select>';
        return $string;
    }
}
