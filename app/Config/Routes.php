<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->group('api',function($routes){
    $routes->post("register", "Register::index");
    $routes->post("login", "Login::index");
    $routes->get("userspost", "Userpost::index", ['filter' => 'authFilter']);

    $routes->post("addpost", "PostController::addpost", ['filter' => 'authFilter']);
    $routes->get('editpost/(:num)', 'PostController::editpost/$1', ['filter' => 'authFilter']);
    $routes->post('updatepost', 'PostController::updatepost');
    $routes->get('removepost/(:num)', 'PostController::removepost/$1', ['filter' => 'authFilter']);

});
