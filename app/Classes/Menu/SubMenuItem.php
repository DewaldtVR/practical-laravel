<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/23
 * Time: 14:13
 */

namespace App\Classes\Menu;


use Auth;
use Illuminate\Support\Facades\View;

class SubMenuItem
{
    protected $menu = [];
    protected $idcount;
    protected $name;
    protected $itemid = 0;

    public function __construct($name)
    {
        $this->name = $name;
    }

    private function hasRight($rightOrClosure)
    {
        if ($rightOrClosure === null)
            return true;
        elseif (is_callable($rightOrClosure))
            return $rightOrClosure();
        elseif (Auth::user()) {
            return Auth::user()->hasRight($rightOrClosure);
        } else {
            return false;
        }

    }

    public function makeId()
    {
        return $this->name . "_" . $this->idcount;
    }

    public function route($label, $routeName, $params = [], $icon = null, $rightOrClosure = null)
    {
        if ($this->hasRight($rightOrClosure)) {
            $this->menu[$this->makeId()] = $this->item()
                ->id($this->makeId())
                ->label($label)
                ->route(route($routeName, $params))
                ->icon($icon);
            $this->idcount++;
        }
        return $this;
    }

    public static function item()
    {
        return new MenuItem();
    }

    public function getMenus()
    {
        return $this->menu;
    }

}