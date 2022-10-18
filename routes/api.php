<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'auth'

], function () {

    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::get('me', [AuthController::class,'me']);
    
});

Route::group([
    'prefix'=> 'auth'
], function (){
    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
});

Route::group([
    'prefix' => 'products',
], function() {
    Route::group([
        'middleware' => ['auth:api', 'role:admin']
    ], function () {
        Route::get('/', function () {
            return "Aqui estan todos los productos";
        });
        Route::post('/', function () {
            return "Aqui estas creando un producto";
        });
        Route::put('/{id}', function ($id) {
            return "Aqui estas actualiando el producto con id: $id";
        });
        Route::delete('/{id}', function ($id) {
            return "Aqui estas eliminando el producto con id: $id";
        });
    });
    Route::group([
        'middleware' => ['auth:api', 'permission:list product']
    ], function () {
        Route::get('/{id}', function ($id) {
            return "Aqui esta el producto con id: $id";
        });
    });
});