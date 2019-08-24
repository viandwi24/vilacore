<?php
namespace App\Helpers;

class Plugin {
    private static $active = null;
    private static $coreLoad = [];
    private static $route = [];
    private static $menu = [];

    public static function saveCoreLoad($core)
    {
        self::$coreLoad = $core;
    }

    public static function getCoreLoad()
    {
        return self::$coreLoad;
    }

    public static function getAll($enableOnly = false, $hideShow = true)
    {
        // error_reporting(E_ERROR);
        $list = file_get_contents(app_path('Core/list.json'));
        $list = json_decode($list, true);

        $show = $enableOnly ? $list['enable'] : $list['load'];
        
        if(!$hideShow) {
            foreach ($list['hide'] as $item) {
                $search = array_search($item, $show);
                if (!$search === false) {
                    unset($show[$search]);
                }
            }
        }


        return $show;
    }

    public static function getAllWithInfo($enableOnly = false, $hideShow = true)
    {
        $listJSON = file_get_contents(app_path('Core/list.json'));
        $listJSON = json_decode($listJSON, true);

        $lists = self::getAll($enableOnly, $hideShow);
        $plugins = [];
        $show = $enableOnly ? $listJSON['enable'] : $listJSON['load'];

        foreach($lists as $list)
        {
            $plugin = self::getInfo($list);
            $plugin = (array) $plugin;
            $plugin['hide'] = false;
            $plugin = (object) $plugin;


            if($hideShow) {
                foreach ($listJSON['hide'] as $item) {
                    $search = array_search($item, $show);
                    if (!$search === false && $show[$search] == $plugin->package) {
                        $plugin = (array) $plugin;
                        $plugin['hide'] = true;
                        $plugin = (object) $plugin;
                    }
                }
            }

            array_push($plugins, (object) $plugin);
        }
        
        

        return $plugins;
    }

    public static function setActive($name)
    {
        self::$active = $name;
    }

    public static function getActive()
    {
        return self::$active;
    }

    public static function getContentHeaderSettingPage()
    {
        return admin()->contentHeader(self::$active . ' Setting', [
            ['name' => 'Admin'], 
            ['name' => 'Alat'], 
            ['name' => self::$active, 'active' => '']
        ]);
    }

    public static function getAdminRoutePrefix()
    {
        return env('ADMIN_URL_PREFIX') . '/alat' . '/' . self::$active;
    }

    public static function getInfo($plugin)
    {
        $enable_list = self::getAll(true);
        $path = app_path('Core/' . $plugin . '/info.json');
        $info = file_get_contents($path);
        $info = json_decode($info, true);
        $info['package'] = $plugin;
        $info['status'] = (array_search($plugin, $enable_list) === false) ? false : true;
        $info = json_encode($info);
        $info = json_decode($info);
        return (object) $info;
    }


    public static function toggle($package)
    {
        $plugin = self::getInfo($package);
        if ($plugin->status) {
            //matikan
            $plugins = file_get_contents(app_path('Core/list.json'));
            $plugins = json_decode($plugins, true);
            $search = array_search($package, $plugins['enable']);
            unset($plugins['enable'][$search]);
            $plugins = json_encode($plugins);
            file_put_contents(app_path('Core/list.json'), $plugins);
            return false;
        } else {
            $plugins = file_get_contents(app_path('Core/list.json'));
            $plugins = json_decode($plugins, true);
            array_push($plugins['enable'], $package);
            $plugins = json_encode($plugins);
            file_put_contents(app_path('Core/list.json'), $plugins);
            return true;
        }
    }

    public static function check($name)
    {
        $plugins = self::getAll();
        return (array_search($name, $plugins) === false) ? false : true;
    }

    public static function getVersion()
    {
        return env('VILACORE_CORE_VERSION', "1.0.0");
    }

    public function setRoutePlugin($route)
    {
        self::$route = $route;
    }

    public static function setMenuPlugin($package, $menu)
    {
        self::$menu[$package] = $menu;
    }

    public static function getPermissionPlugin($package)
    {
        if (!self::getInfo($package)->status) return (object) [];
        return (object) [
            "package" => $package,
            "route" => customRoute()->getRoutePlugin($package),
            "routeFile" => customRoute()->getRouteFilePlugin($package),
            "menu" => customMenu()->getMenuPlugin($package),
            "dashboardInfoBox" => admin()->getDashboardInfoBoxPlugin($package),
            "dashboardWidget" => admin()->getDashboardWidgetPlugin($package),
        ];
    }
}