<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/25
 * Time: 09:16
 */

namespace App\Classes\Thunder\Fields;


use App\Classes\Thunder\Field;

class DateTimeField extends Field
{
    public function __construct($fieldName, $label, $dataType)
    {
        parent::__construct($fieldName, $label, $dataType);
    }
}