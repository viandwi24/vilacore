<?php
namespace App\Helpers;

class CustomMenu {
    private static $menu = [];
    private static $menuPlugin = [];

    public static function load()
    {
        return self::$menu;
    }

    public static function add($menu)
    {
        $plugin = plugin()->getActive();
        array_push(self::$menu, $menu);
        self::$menuPlugin[$plugin][] = $menu;
    }

    public static function getMenuPlugin($package)
    {
        return self::$menuPlugin[$package];
    }
}