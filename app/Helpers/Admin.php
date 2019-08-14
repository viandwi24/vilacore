<?php
namespace App\Helpers;

class Admin {
  private static $dashboardInfoBox = [];
  private static $dashboardInfoBoxPlugin = [];
  private static $dashboardWidget = [];
  private static $dashboardWidgetPlugin = [];

    public static function contentHeader($name, $path)
    {
        $tag_s = '<div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">'.$name.'</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">';
        
        $el_path = '';
        foreach($path as $item)
        {
            $active = isset($item['active']) ? ' active' : '';
            if(isset($item['link'])) {
                $el_path .= '<li class="breadcrumb-item'.$active.'">
                    <a href="'.$item['link'].'">'.$item['name'].'</a>
                </li>';
            } else {
                $el_path .= '<li class="breadcrumb-item'.$active.'">'.$item['name'].'</li>';
            }
        }

        $tag_e = '</ol>
          </div>
        </div>
      </div>';


      return $tag_s . $el_path . $tag_e;
    }

    public static function addDashboardWidget($items)
    {
      self::$dashboardWidgetPlugin[plugin()->getActive()][] = $items;
      array_push(self::$dashboardWidget, $items);
    }

    public static function getDashboardWidget()
    {
      $items = self::$dashboardWidget;
      return $items;
    }
    
    public static function getDashboardWidgetPlugin($package){
      return isset(self::$dashboardWidgetPlugin[$package]) ? self::$dashboardWidgetPlugin[$package] : [];
    }
    public static function getDashboardInfoBoxPlugin($package){
      return isset(self::$dashboardInfoBoxPlugin[$package]) ? self::$dashboardInfoBoxPlugin[$package] : [];
    }

    public static function addDashboardInfoBox($items)
    {
      self::$dashboardInfoBoxPlugin[plugin()->getActive()][] = $items;
      array_push(self::$dashboardInfoBox, $items);
    }

    public static function getDashboardInfoBox()
    {
      $items = self::$dashboardInfoBox;
      $tag_s = '<div class="row">';
      $el_list = '';
      $tag_e = '</div>';

      foreach($items as $item)
      {
        $el_list .= '<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon '.@$item['icon-box'].' elevation-1"><i class="fas far '.@$item['icon'].'"></i></span>
                <div class="info-box-content">
                <span class="info-box-text">'.$item['title'].'</span>
                <span class="info-box-number">
                    '.$item['value'].'
                </span>
                </div>
            </div>
        </div>';
      }

      return $tag_s . $el_list . $tag_e;
    }

    public static function getAdminTitlePage($title = '')
    {
      if ($title == '') return env('APP_NAME', 'Vilacore') . ' Admin';
      return $title . ' | ' . env('APP_NAME', 'Vilacore') . ' Admin';
    }
}