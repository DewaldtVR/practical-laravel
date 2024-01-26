<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/25
 * Time: 12:03
 */

namespace App\Classes\Bridge;


class Bridge
{
    public static function view($view, $data = [])
    {
        \View::share("serverData", json_encode($data));
        return view($view, $data);
    }
}