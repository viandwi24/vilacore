<?php

if (! function_exists('plugin')) {
    function plugin()
    {
        return app(\App\Helpers\Plugin::class);
    }
}

if (! function_exists('admin')) {
    function admin()
    {
        return app(\App\Helpers\Admin::class);
    }
}

if (! function_exists('customMenu')) {
    function customMenu()
    {
        return app(\App\Helpers\CustomMenu::class);
    }
}

if (! function_exists('customRoute')) {
    function customRoute()
    {
        return app(\App\Helpers\CustomRoute::class);
    }
}

