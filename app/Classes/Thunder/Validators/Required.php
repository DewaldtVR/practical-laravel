<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/26
 * Time: 23:48
 */

namespace App\Classes\Thunder\Validators;


use App\Classes\Thunder\Validator;

class Required extends Validator
{
    protected $type = "required";
    protected $name;
    protected $description;
    protected $value;

    public function __construct()
    {

    }

    public static function create($name, $description = "This field is required")
    {
        $class = new self;
        $class->name = $name;
        $class->description = $description;
        return $class;
    }
}