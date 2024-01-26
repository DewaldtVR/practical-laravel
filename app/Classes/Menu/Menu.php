<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/22
 * Time: 22:11
 */

namespace App\Classes\Menu;

use Auth;
use Illuminate\Support\Facades\View;

class Menu
{

    protected $menu = [];
    protected $idcount = 0;
    protected $name;

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

    public function pushRoute($label, $routeName, $params = [], $icon = null, $rightOrClosure = null)
    {
        if ($this->hasRight($rightOrClosure)) {
            $this->idcount++;
            array_unshift($this->menu, $this->item()
                ->id($this->makeId())
                ->label($label)
                ->route(route($routeName, $params))
                ->icon($icon)
            );
        }
        return $this;
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

    public function pushGroup($label, $icon = null)
    {
        $temp[$this->makeId()] = $this->item("group")
            ->id($this->makeId())
            ->label($label)
            ->icon($icon);
        $prevId = $this->makeId();
        $this->idcount++;
        $this->menu = $temp + $this->menu;
        return $this->menu[$prevId];
    }

    public function group($label, $icon = null)
    {
        $this->menu[$this->makeId()] = $this->item("group")
            ->id($this->makeId())
            ->label($label)
            ->icon($icon);
        $prevId = $this->makeId();
        $this->idcount++;
        return $this->menu[$prevId];
    }

    public static function item($type = null)
    {
        return new MenuItem($type);
    }

    public function exposeMenu()
    {
        $menuArray = [];
        foreach ($this->menu as $menu) {
            $menu = $menu->toArray();
            if (!empty($menu))
                $menuArray[] = $menu;
        }
        View::share($this->name, $menuArray);
    }

}