<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/27
 * Time: 00:32
 */

namespace App\Classes\Thunder\Validators;


use App\Classes\Thunder\Validator;

class Pattern extends Validator
{
    protected $type = "pattern";
    protected $name;
    protected $value;
    protected $description;

    public function __construct()
    {

    }

    public static function create($name, $description,$pattern)
    {
        $class = new self;
        $class->name = $name;
        $class->description = $description;
        $class->value = $pattern;
        return $class;
    }
}