<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/27
 * Time: 01:03
 */

namespace App\Classes\Thunder;


class Mask
{
    protected $mask;
    protected $label;

    public static function create($label, $mask)
    {
        $class = new self;
        $class->label = $label;
        $class->mask = $mask;
        return $class;
    }

    public function toArray()
    {
        return [
            "mask" => $this->mask,
            "label" => $this->label
        ];
    }
}