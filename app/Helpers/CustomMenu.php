<?php
namespace App\Helpers;

class CustomMenu {
    private static $menu = [];

    public static function load()
    {
        return self::$menu;
    }

    public static function add($menu)
    {
        array_push(self::$menu, $menu);
    }
}