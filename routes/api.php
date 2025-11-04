<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:api']], function ()
{
    ///USERS
    Route::get('/user',[\App\Http\Controllers\API\AuthController::class, 'Profile']);
    Route::post('ProfileUpdate', [\App\Http\Controllers\API\AuthController::class, 'ProfileUpdate']);
    Route::post('/ChangePassword',[\App\Http\Controllers\API\AuthController::class, 'ChangePassword']);
    Route::any('/logout',[\App\Http\Controllers\API\AuthController::class, 'Remove']);


    //Set Budget
    Route::post('/SetBudget',[\App\Http\Controllers\API\PullProcessController::class, 'SetBudget']);

    //Set Budget
    Route::post('/Budges',[\App\Http\Controllers\API\BudgesController::class, 'list']);

    //Get Question List
    Route::post('/Questions',[\App\Http\Controllers\API\QuestionController::class, 'GetQuestion']);
    Route::post('/SubmitQuestions',[\App\Http\Controllers\API\QuestionController::class, 'SubmitQuestion']);

    /////CHILD
    Route::any('/child',[\App\Http\Controllers\API\ChildController::class, 'child_list']);
    Route::any('/child/add',[\App\Http\Controllers\API\ChildController::class, 'ChildAdd']);
    Route::any('/child/pull_history',[\App\Http\Controllers\API\ChildController::class, 'PullHistory']);
    Route::any('/child/teeth/pull',[\App\Http\Controllers\API\PullProcessController::class, 'Pull']);
    Route::any('/child/invest',[\App\Http\Controllers\API\PullProcessController::class, 'invest']);
    Route::any('/child/cashout',[\App\Http\Controllers\API\PullProcessController::class, 'cashout']);

    //////Mile Stone
    Route::post('/MillStone',[\App\Http\Controllers\API\PullProcessController::class, 'Milestore']);
});

Route::post('TestApi',[\App\Http\Controllers\API\AuthTestController::class, 'test']);

Route::post('/register',[\App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/Social',[\App\Http\Controllers\API\AuthController::class, 'social_login']);
Route::post('/login',[\App\Http\Controllers\API\AuthController::class, 'login']);
Route::post('/forgot',[\App\Http\Controllers\API\AuthController::class, 'forgot']);
Route::post('/reset',[\App\Http\Controllers\API\AuthController::class, 'reset']);
Route::post('/encryption',[\App\Http\Controllers\API\TestController::class, 'exception']);
Route::post('/decryption',[\App\Http\Controllers\API\TestController::class, 'decryption']);
Route::any('/currency/get',[\App\Http\Controllers\API\PullProcessController::class, 'getCurrency']);