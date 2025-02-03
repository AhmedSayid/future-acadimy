<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login',[AuthController::class ,'login']);
Route::middleware(['auth:sanctum','verifyApi.device','check.block'])->group(function (){
    Route::get('get-subjects',[SubjectController::class,'getSubjects']);
    Route::get('get-subjects',fn() => dd('ss'));
    Route::get('get-chapters/{id}',[SubjectController::class,'getChapters']);
    Route::get('get-videos/{subject_id}/{id?}',[SubjectController::class,'getVideos']);
    Route::get('notifications' , [NotificationController::class , 'index']);
    Route::post('send-notification',[NotificationController::class,'store']);
});
