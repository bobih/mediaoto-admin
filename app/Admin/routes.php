<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

	$router->resource('articles', ArtcleController::class);
	$router->resource('prospeks', ProspekController::class);
	$router->resource('users', UserController::class);
	$router->resource('pakets', PaketController::class);
	$router->resource('brands', BrandController::class);
	$router->resource('showrooms', ShowroomController::class);
	$router->resource('provinces', ProvinceController::class);
	$router->resource('cities', CityController::class);

	$router->resource('leads', LeadController::class);

});
