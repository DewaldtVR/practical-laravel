<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/27
 * Time: 10:56
 */

namespace App\Classes\Thunder\Fields;


use App\Classes\Thunder\Field;

class TimeField extends  Field
{
    public function __construct($fieldName, $label, $dataType)
    {
        parent::__construct($fieldName, $label, $dataType);
    }
}