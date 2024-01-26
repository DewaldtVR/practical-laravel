<?php

namespace App\Traits;


use App\Classes\Thunder\Mask;
use App\Classes\Thunder\Validator;
use App\Classes\Thunder\Validators\Pattern;
use App\Classes\Thunder\Validators\Required;

trait FieldValidation
{
    protected $validators = [];
    protected $masks = [];
    protected $canFilterOn = false;

    public function addValidator(Validator $validator)
    {
        $this->validators[] = $validator;
        return $validator;
    }

    public function addMask(Mask $mask)
    {
        $this->masks[] = $mask;
        return $mask;
    }

    public function mask($label, $mask)
    {
        $this->addMask(Mask::create($label, $mask));
        return $this;
    }

    public function required($description = "This field is required")
    {
        $this->addValidator(Required::create($this->fieldName, $description));
        return $this;
    }

    public function pattern($description = "This field is not valid", $pattern)
    {
        $this->addValidator(Pattern::create($this->fieldName, $description, $pattern));
        return $this;
    }

    public function before()
    {
        return $this;
    }

    public function type()
    {
        return $this;
    }

    public function canFilter($trueOrFalse = false)
    {
        $this->canFilterOn = $trueOrFalse;
        return $this;
    }

    public function getCanFilter()
    {
        return $this->canFilterOn;
    }

    public function getMasks()
    {
        $maskList = [];
        foreach ($this->masks as $mask) {
            $maskList[] = $mask->toArray();
        }
        return $maskList;
    }

    public function getValidators()
    {
        $validatorList = [];
        foreach ($this->validators as $validator) {
            $validatorList[] = $validator->toArray();
        }
        return $validatorList;
    }
}
