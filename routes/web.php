<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankQuestionController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/',[DashboardController::class ,'getHomePage']);

Route::get('login' , [AuthController::class , 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class , 'login'])->name('postLogin')->middleware('verify.device');
Route::get('go-out' , function (){
   Auth::logout();
   return redirect()->route('login');
});

Route::middleware(['auth'])->prefix('platform/')->group(function (){

    Route::get('search',[DashboardController::class , 'search'])->name('search');
    Route::get('/home' , [DashboardController::class ,'platform'])->name('platform.index');

    Route::controller(UserController::class)->as('teachers.')->prefix('teachers/')->group(function (){
        Route::get('' , 'index')->name('index');
        Route::get('change-status', 'changeBlockStatus')->name('change-status');
        Route::get('get-teacher-data/{id}', 'getTeacherData')->name('get-teacher-data');
        Route::post('store' , 'store')->name('store');
        Route::get('show/{id}' , 'show')->name('show');
        Route::post('update/{id}' , 'update')->name('update');
        Route::delete('delete/{id}' , 'delete')->name('delete');
    });

    Route::controller(ErrorLogController::class)->as('errors.')->prefix('errors')->group(function (){
       Route::get('/','index')->name('index');
       Route::get('/get-message/{id}','getMessage')->name('get-error-msg');
    });

    Route::controller(GradeController::class)->as('grades.')->prefix('grades/')->group(function (){
        Route::get('' , 'index')->name('index');
        Route::get('get-grade-data/{id}', 'getGradeData')->name('get-grade-data');
        Route::post('store' , 'store')->name('store');
        Route::post('update/{id}' , 'update')->name('update');
        Route::delete('delete/{id}' , 'delete')->name('delete');
    });
    Route::controller(SubjectController::class)->as('subjects.')->prefix('subjects/')->group(function (){
        Route::get('' , 'index')->name('index');
        Route::get('get-subject-data/{id}', 'getSubjectData')->name('get-subject-data');
        Route::post('store' , 'store')->name('store');
        Route::post('update/{id}' , 'update')->name('update');
        Route::delete('delete/{id}' , 'delete')->name('delete');
        Route::get('/get-subjects/{grade_id}', 'getSubjects')->name('getSubjects');
    });
    Route::controller(ChapterController::class)->as('chapters.')->prefix('chapters/')->group(function (){
        Route::get('/{id}' ,'index')->name('index');
        Route::get('get-chapter-data/{id}', 'getChapterData')->name('get-chapter-data');
        Route::post('store' ,'store')->name('store');
        Route::post('update/{id}' ,'update')->name('update');
        Route::delete('delete/{id}','delete')->name('delete');
    });
    Route::controller(StudentController::class)->as('students.')->prefix('students/')->group(function (){
        Route::get('' , 'index')->name('index');
        Route::get('change-status', 'changeBlockStatus')->name('change-status');
        Route::get('get-student-data/{id}', 'getStudentData')->name('get-student-data');
        Route::post('store' , 'addStudent')->name('store');
        Route::get('show/{id}' , 'show')->name('show');
        Route::post('update/{id}' , 'update')->name('update');
        Route::delete('delete/{id}' , 'delete')->name('delete');
    });
    Route::controller(CourseController::class)->as('courses.')->prefix('courses/')->group(function (){
        Route::get('{id}' , 'index')->name('index');
        Route::get('create/{id}','create')->name('create');
        Route::post('store' , 'store')->name('store');
        Route::post('upload-video', 'uploadVideo')->name('upload-video');
        Route::post('show' , 'show')->name('show');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}' , 'update')->name('update');
        Route::delete('delete/{id}' , 'delete')->name('delete');
    });
    Route::controller(BankQuestionController::class)->as('questions.')->prefix('questions/')->group(function (){
        Route::get('{id}' , 'index')->name('index');
        Route::get('get-question-data/{id}', 'getQuestionData')->name('get-question-data');
        Route::post('store' , 'store')->name('store');
        Route::post('update/{id}' , 'update')->name('update');
        Route::delete('delete/{id}' , 'delete')->name('delete');
    });
});

//Route::get('/{page}', [DashboardController::class,'index']);
