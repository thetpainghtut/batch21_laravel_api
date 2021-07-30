<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Http\Resources\UserResource;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users',function(){
    $users = User::all();
    return UserResource::collection($users);
});

// Frontend
Route::get('items','FrontendController@getItems')->name('items.all');

// Backend
Route::middleware('auth:sanctum')->group(function () {
    Route::apiresource('brand','BrandController');
    Route::apiresource('category','CategoryController');
    Route::apiresource('subcategory','SubcategoryController');
    Route::apiresource('item','ItemController');

    Route::get('testing','UserController@testing'); // abilities
    Route::post('logout','UserController@logout'); // revoke
});

// Auth
Route::post('register','UserController@register');
Route::post('login','UserController@login');