<?php

namespace App\Traits;

use App\Classes\Menu\MenuBuilder;

trait MenuExpose
{
    public static function exposeMenus()
    {
        MenuBuilder::menu("main")->exposeMenu();
        MenuBuilder::menu("top")->exposeMenu();
    }
}
