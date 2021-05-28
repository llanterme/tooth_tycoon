<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');

Route::post('/login','AdminController@login')->name('login');

Route::group(['prefix'=>'admin','middleware' => ['AdminCheck','web']], function()
{
    Route::get('home','AdminController@home');
    Route::get('/','AdminController@home');
    Route::any('/logout','AdminController@logout');
    Route::get('/User','UserController@index')->name("User");
    Route::get('/User/TeethDetail/{id}','UserController@TeethDetail')->name("User-Detail");
    Route::get('/User/Childe/{id}','UserController@Child')->name("User-Child-List");
    Route::get('/User/ChildeDetail/{id}','UserController@ChildePullList')->name("Childe-Teeth");
    Route::get('/User/Childe/{id}/invest','UserController@ChildeInvest')->name("Childe-invest");
    Route::get('/User/Childe/{id}/CashOut','UserController@CashOut')->name("Childe-Cashout");
    Route::get('/User/{id}','UserController@edit')->name("User-Edit");
    Route::post('/User/{id}','UserController@update')->name("User-Update");
    Route::get('/Budget','BudgetController@index')->name("Budget");
    Route::resource('/Budges', 'BadgesController');
    Route::get('/Budges/Question/{id}','QuestionController@index')->name('Budges.Question');
    Route::get('/Budges/Question/Add/{badges_id}', 'QuestionController@AddQuestion')->name('Budges.Question.Add');
    Route::post('/Budges/Question/Add/{badges_id}', 'QuestionController@StoreQuestion')->name('Budges.Question.Add');
    Route::get('/Budges/Question/Edit/{question_id}', 'QuestionController@EditQuestion')->name('Budges.Question.Edit');
    Route::post('/Budges/Question/Edit/{question_id}', 'QuestionController@UpdateQuestion')->name('Budges.Question.Edit');
    Route::get('/Budges/Question/Delete/{question_id}', 'QuestionController@SoftDeleteQuestion')->name('Budges.Question.Delete');
    Route::get('/Invest','InvestController@index')->name('invest');
    Route::get('/CashOut','CashOutController@index')->name('CashOut');
    Route::get('/tooth-reward-setting','ToothRewardController@index')->name('tooth-reward-setting');
    Route::post('/reward-save','ToothRewardController@update')->name("reward-save");
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('sendtest','SendMailController@send');

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
