<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\CategoryController;

  
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
  
Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
     
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);
    Route::middleware('isLogin', 'CheckRole:admin,user')->group(function(){
        Route::get('items', [ItemController::class, 'index']);
        Route::get('category/items', [ItemController::class, 'getItemHasCategory']);

    });
    Route::middleware('isLogin', 'CheckRole:admin')->group(function(){
        Route::post('items/create', [ItemController::class, 'store']);
        Route::put('items/update/{id}', [ItemController::class, 'update']);
        Route::delete('items/delete/{id}', [ItemController::class, 'destroy']);
        Route::post('category/create', [CategoryController::class, 'store']);

    });
    Route::get('logout', [AuthController::class, 'logout']);
});

Route::get('home/items/', [ItemController::class, 'topItem']);