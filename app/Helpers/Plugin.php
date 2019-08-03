<?php
namespace App\Helpers;

class Plugin {
    private static $active = null;
    private static $coreLoad = [];

    public static function saveCoreLoad($core)
    {
        self::$coreLoad = $core;
    }

    public static function getCoreLoad()
    {
        return self::$coreLoad;
    }

    public static function getAll($enableOnly = false)
    {
        error_reporting(E_ERROR);
        $list = file_get_contents(app_path('Core/list.json'));
        $list = json_decode($list, true);

        error_reporting();
        $show = $enableOnly ? $list['enable'] : $list['load'];

        foreach ($list['hide'] as $item) {
            $search = array_search($item, $show);
            if (!$search === false) {
                unset($show[$search]);
            }
        }

        return $show;
    }

    public static function getAllWithInfo($enableOnly = false)
    {
        $lists = self::getAll($enableOnly);
        $plugins = [];
        // return [];

        foreach($lists as $list)
        {
            $plugin = self::getInfo($list);
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
        // dd(get_parent_class())  ;
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
    
}