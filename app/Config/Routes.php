<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('api/recipes/search',        'RecipeController::search');
$routes->get('api/recipes/random',        'RecipeController::random');
$routes->get('api/recipes/detail/(:num)', 'RecipeController::detail/$1');