<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('/',IndexController::class,[
    'only' =>['index'],
    'names' => ['index'=> 'index']
]);

Route::resource('/product',ProductController::class,[
    'only' =>['index'],
    'names' => ['index'=> 'product']
]);


Route::group(['prefix' => 'site/api/v1', 'namespace' => 'Api\V1','as' => 'site.api.' ], function () {
    Route::post('/xml/upload', [\App\Http\Controllers\Api\V1\UploadXmlFileController::class, 'store'])->name('upload.xml.file');
    Route::get('/product', [\App\Http\Controllers\Api\V1\ProductController::class, 'index'])->name('product');
});
