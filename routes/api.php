<?php

use App\Http\Controllers\Api\RecommendItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductContentController;

use App\Http\Controllers\Api\ContentController;

Route::get('/contents', [ContentController::class, 'index']);
Route::post('/contents', [ContentController::class, 'store']);
Route::delete('/contents/{id}', [ContentController::class, 'destroy']);
Route::get('/content/{id}', [ContentController::class, 'show']);

Route::get('/products', [ProductContentController::class, 'index']);
Route::post('/products', [ProductContentController::class, 'store']);
Route::get('/product/{id}', [ProductContentController::class, 'show']);

Route::options('{any}', function () {
    return response('', 204, [
        'Access-Control-Allow-Origin' => 'https://starringwhite.base.shop',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With',
    ]);
})->where('any', '.*');
Route::get('/recommend', [RecommendItemController::class, 'index']);     // 公開JSON
Route::apiResource('recommend-items', RecommendItemController::class);   // 管理用API

// 管理用（一覧だけ分離）
Route::get('/admin/recommend-items/all', [RecommendItemController::class, 'showAll']);
?>


