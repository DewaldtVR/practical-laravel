<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/07/11
 * Time: 22:22
 */

namespace App\Classes\Thunder\Fields;


use App\Classes\Thunder\Field;

class EnumField extends Field
{
    public function __construct($fieldName, $label, $values, $dataType)
    {
        parent::__construct($fieldName, $label, $dataType,$values);
    }
}