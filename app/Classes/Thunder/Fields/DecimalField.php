<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/07/25
 * Time: 19:35
 */

namespace App\Classes\Thunder\Fields;


use App\Classes\Thunder\Field;

class DecimalField extends Field
{
    public function __construct($fieldName, $label, $dataType)
    {
        parent::__construct($fieldName, $label, $dataType);
    }
}