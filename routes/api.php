<?php

use App\Http\Controllers\Api\RecommendItemController;
use Illuminate\Support\Facades\Route;

Route::options('{any}', function () {
    return response('', 204, [
        'Access-Control-Allow-Origin' => 'https://starringwhite.base.shop',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With',
    ]);
})->where('any', '.*');
Route::get('/recommend', [RecommendItemController::class, 'index']);     // 公開JSON
Route::apiResource('recommend-items', RecommendItemController::class);   // 管理用API
?>