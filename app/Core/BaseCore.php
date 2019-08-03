<?php
namespace App\Core;

interface BaseCore {
    public function register();
    public function boot();
    public function map();
    public function load($request, $next);
    public function terminate($request);
}