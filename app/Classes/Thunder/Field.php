<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/16
 * Time: 04:56
 */

namespace App\Classes\Thunder;


use App\Traits\FieldPermission;
use App\Traits\FieldValidation;

class Field
{

    protected $fieldName;
    protected $label;
    protected $dataType;
    protected $prefix;
    protected $default;
    protected $values;
    protected $max;
    protected $min = 0;


    use FieldValidation;
    use FieldPermission;


    public function __construct($fieldName, $label, $dataType, $values = [])
    {
        $this->fieldName = $fieldName;
        $this->label = $label;
        $this->dataType = $dataType;
        $this->values = $values;
    }

    public function default($default)
    {
        $this->default = $default;
        return $this->default;
    }

    public function prefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function max($value)
    {
        $this->max = $value;
        return $this;
    }

    public function min($value)
    {
        $this->min = $value;
        return $this;
    }

    public function getMax()
    {
        return $this->max;
    }

    public function getMin()
    {
        return $this->min;
    }
}