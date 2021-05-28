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
    Route::get('/user','API\AuthController@Profile');
    Route::post('ProfileUpdate', 'API\AuthController@ProfileUpdate');
    Route::post('/ChangePassword','API\AuthController@ChangePassword');
    Route::any('/logout','API\AuthController@Remove');

    
    //Set Budget
    Route::post('/SetBudget','API\PullProcessController@SetBudget');

    //Set Budget
    Route::post('/Budges','API\BudgesController@list');

    //Get Question List
    Route::post('/Questions','Api\QuestionController@GetQuestion');
    Route::post('/SubmitQuestions','API\QuestionController@SubmitQuestion');

    /////CHILD
    Route::any('/child','API\ChildController@child_list');
    Route::any('/child/add','API\ChildController@ChildAdd');
    Route::any('/child/pull_history','API\ChildController@PullHistory');
    Route::any('/child/teeth/pull','API\PullProcessController@Pull');
    Route::any('/child/invest','API\PullProcessController@invest');
    Route::any('/child/cashout','API\PullProcessController@cashout');

    //////Mile Stone
    Route::post('/MillStone','API\PullProcessController@Milestore');
});

Route::post('TestApi','Api\AuthTestController@test');

Route::post('/register','API\AuthController@register');
Route::post('/Social','API\AuthController@social_login');
Route::post('/login','API\AuthController@login');
Route::post('/forgot','API\AuthController@forgot');
Route::post('/reset','API\AuthController@reset');
Route::post('/encryption','API\TestController@exception');
Route::post('/decryption','API\TestController@decryption');
Route::any('/currency/get','API\PullProcessController@getCurrency');