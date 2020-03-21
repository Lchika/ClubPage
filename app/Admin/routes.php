<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/posts', PostController::class);
    $router->resource('/comments', CommentController::class);
    $router->resource('/news', NewsController::class);
    $router->resource('/tags', TagController::class);
    $router->resource('/tagmaps', TagmapController::class);
});
