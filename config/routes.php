<?php
use Cake\Routing\Router;

Router::plugin('FileManager', function ($routes) {
    $routes->prefix('Admin', function ($routes) {

        $routes->connect('/:controller/:action/**', [
        ]);

        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});
