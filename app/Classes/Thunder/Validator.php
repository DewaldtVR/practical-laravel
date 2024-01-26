<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/26
 * Time: 23:54
 */

namespace App\Classes\Thunder;


class Validator
{
    public function toArray()
    {
        return [
            "type" => $this->type,
            "name" => $this->name,
            "description" => $this->description,
            "value" => $this->value
        ];
    }
}