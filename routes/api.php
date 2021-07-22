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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users',function(){
    $users = User::all();
    return UserResource::collection($users);
});

Route::middleware('auth:sanctum')->apiresource('brand','BrandController');
Route::apiresource('category','CategoryController');
Route::apiresource('subcategory','SubcategoryController');


// Auth
Route::post('register','UserController@register');

