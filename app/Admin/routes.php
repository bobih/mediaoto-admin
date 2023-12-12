<?php

use Illuminate\Routing\Router;
use \App\Admin\Controllers\ArtcleController;
use \App\Admin\Controllers\ProspekController;
use \App\Admin\Controllers\UserController;
use \App\Admin\Controllers\ListPaketController;
use \App\Admin\Controllers\BrandController;
use \App\Admin\Controllers\ShowroomController;
use \App\Admin\Controllers\ProvinceController;
use \App\Admin\Controllers\CityController;
use \App\Admin\Controllers\LeadController;
use \App\Admin\Controllers\PositionController;
use \App\Admin\Controllers\ListPositionController;
use \App\Admin\Controllers\ListCallController;
use \App\Admin\Controllers\ListWaController;
use \App\Admin\Controllers\ListAdsController;
use \App\Admin\Controllers\ListPushController;
use \App\Admin\Controllers\InvoiceController;




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
	$router->resource('pakets', ListPaketController::class);
	$router->resource('brands', BrandController::class);
	$router->resource('showrooms', ShowroomController::class);
	$router->resource('provinces', ProvinceController::class);
	$router->resource('cities', CityController::class);

	$router->resource('leads', LeadController::class);
    $router->resource('positions', PositionController::class);
    $router->resource('list-positions', ListPositionController::class);
    $router->resource('list-calls', ListCallController::class);
    $router->resource('list-was', ListWaController::class);

    $router->resource('list-ads', ListAdsController::class);
    $router->resource('list-pushes', ListPushController::class);

    $router->resource('invoices', InvoiceController::class);


});
