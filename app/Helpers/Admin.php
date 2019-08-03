<?php
namespace App\Helpers;

class Admin {

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
}