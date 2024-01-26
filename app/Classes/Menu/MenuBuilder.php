<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/23
 * Time: 09:58
 */

namespace App\Classes\Menu;


class MenuBuilder
{
    protected $menus = [];

    public static function menu($name): Menu
    {
        $class = new self();
        return $class->menuSession($name);
    }

    public function menuSession($name)
    {
        if (\Session::has($name)) {
            return \Session::get($name);
        } else {
            \Session::flash($name, new Menu($name));
            return \Session::get($name);
        }
    }
}