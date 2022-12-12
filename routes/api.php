<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DreamController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\PermissionController;

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



Route::post('login', [AuthController::class,'login']);

Route::post('sociallogin', [AuthController::class,'sociallogin']);

Route::get('search/{keyword}', [DreamController::class,'search']);

Route::get('categories/dreams/{id}', [DreamController::class,'category_dreams']);

Route::get('recent-dreams', [DreamController::class,'recent']);
Route::get('featured-dreams', [DreamController::class,'frecent']);

Route::post('/user/create', [AuthController::class,'register']);

Route::get('categories', [DreamController::class,'categories']);
Route::get('dream/{id}', [DreamController::class,'view_dream']);

Route::post('update-views', [DreamController::class,'update_view']);

Route::group(['middleware' => 'auth:api'], function(){

	
	

    Route::get('logout', [AuthController::class,'logout']);

	Route::post('change-password', [AuthController::class,'changePassword']);
	Route::post('update-profile', [AuthController::class,'updateProfile']);
	Route::post('update-image', [AuthController::class,'updateImage']);

	
	Route::get('user/dreams/all', [DreamController::class,'user_dreams']);
	Route::get('user/dreams/request', [DreamController::class,'user_dreams_request']);
	Route::get('user/dreams/done', [DreamController::class,'user_dreams_done']);


	Route::post('replay', [DreamController::class,'replay']);
	Route::post('dream', [DreamController::class,'add_new_dream']);
	
	Route::get('chat/{id}', [DreamController::class,'chat']);

	

	Route::post('update-points', [DreamController::class,'update_points']);

	Route::post('update-token', [DreamController::class,'update_token']);

	Route::get('notes', [DreamController::class,'notes']);







	Route::get('profile', [AuthController::class,'profile']);
	

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
		Route::get('/users', [UserController::class,'list']);
		Route::get('/user/{id}', [UserController::class,'profile']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
		Route::post('/user/change-role/{id}', [UserController::class,'changeRole']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'list']);
		Route::post('/role/create', [RolesController::class,'store']);
		Route::get('/role/{id}', [RolesController::class,'show']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
		Route::post('/role/change-permission/{id}', [RolesController::class,'changePermissions']);
	});


	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permissions', [PermissionController::class,'list']);
		Route::post('/permission/create', [PermissionController::class,'store']);
		Route::get('/permission/{id}', [PermissionController::class,'show']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});
	
});
