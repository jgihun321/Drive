<?php

use Illuminate\Support\Facades\Route;
use App\Service\System;
use App\Service\UpDown;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\DriveController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/ //[#가-힣a-zA-Z0-9!@#$%^&*()_+= '*-_\/.,]*

Route::get('/',[DriveController::class,'Index']);

Route::get('/drive/{path}',[DriveController::class,'Directory'])->where('path', ".*");

Route::get('/delete/{path}',[DriveController::class,'Delete'])->where('path', ".*");

Route::post('/newdir',[DriveController::class,'CreateDir'])->where('path', ".*");

Route::post('/rename',[DriveController::class,'Rename'])->where('path', ".*");


Route::post('/login',[AuthController::class,'Login']);

Route::get('/logout',[AuthController::class,'Logout']);


//

Route::get('/boot',[System::class,'boot']);

Route::get('/reboot',[System::class,'reboot']);


//

Route::get('/download/{path}',[UpDown::class,'download'])->where('path', ".*");

Route::get('/play/{path}',[UpDown::class,'playVideo'])->where('path', ".*");

Route::post('/upload',[UpDown::class,'upload']);

Route::get('/upload',[DriveController::class,'Upload']);




Route::get('/admin',[AdminController::class,'index']);

Route::get('/admin/drive/{path}',[AdminController::class,'Directory'])->where('path', ".*");

Route::post('/admin/drive',[AdminController::class,'setDrive']);

Route::post('/admin/security',[AdminController::class,'setSecurity'])->where('path', ".*");


