<?php
/**
 * Created by PhpStorm.
 * User: werner
 * Date: 2019/03/08
 * Time: 22:53
 */

namespace App\Classes\Thunder\Fields;


use App\Classes\Thunder\Field;

class BooleanField extends Field
{
    public function __construct($fieldName, $label, $dataType, $values)
    {
        parent::__construct($fieldName, $label, $dataType, $values);
    }
}