<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/16
 * Time: 04:48
 */

namespace App\Classes\Thunder\Fields;


use App\Classes\Thunder\Field;

class RangeField extends Field
{

    public function __construct($fieldName, $label, $dataType)
    {
        parent::__construct($fieldName, $label, $dataType);
    }
}