<?php
/**
 * Created by PhpStorm.
 * User: werne
 * Date: 2018/06/23
 * Time: 09:02
 */

namespace App\Classes\Menu;


class MenuItem
{
    protected $label;
    protected $route;
    protected $icon;
    protected $itemid;
    protected $subMenu;
    protected $type;

    public function __construct($type = "link")
    {
        $this->type = $type;
    }

    public function id($id)
    {
        $this->itemid = $id;
        $this->subMenu = new SubMenuItem($this->itemid);
        return $this;
    }

    public function label($label)
    {
        $this->label = $label;
        return $this;
    }

    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function route($route)
    {
        $this->route = $route;
        return $this;
    }

    public function subMenu()
    {
        return $this->subMenu;
    }

    public function toArray()
    {

        $item = [
            "label" => $this->label,
            "icon" => $this->icon,
            "href" => $this->route
        ];

        foreach ($this->subMenu()->getMenus() as $menu) {
            $item["submenu"][] = $menu->toArray();
        }
        if (empty($item["submenu"]) && $this->type == "group") {
            return [];
        } else {
            return $item;
        }
    }
}