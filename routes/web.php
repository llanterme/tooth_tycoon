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

Route::post('/login',[\App\Http\Controllers\AdminController::class, 'login'])->name('admin.login');

Route::group(['prefix'=>'admin','middleware' => ['AdminCheck','web']], function()
{
    Route::get('home',[\App\Http\Controllers\AdminController::class, 'home']);
    Route::get('/',[\App\Http\Controllers\AdminController::class, 'home']);
    Route::any('/logout',[\App\Http\Controllers\AdminController::class, 'logout']);
    Route::get('/User',[\App\Http\Controllers\UserController::class, 'index'])->name("User");
    Route::get('/User/TeethDetail/{id}',[\App\Http\Controllers\UserController::class, 'TeethDetail'])->name("User-Detail");
    Route::get('/User/Childe/{id}',[\App\Http\Controllers\UserController::class, 'Child'])->name("User-Child-List");
    Route::get('/User/ChildeDetail/{id}',[\App\Http\Controllers\UserController::class, 'ChildePullList'])->name("Childe-Teeth");
    Route::get('/User/Childe/{id}/invest',[\App\Http\Controllers\UserController::class, 'ChildeInvest'])->name("Childe-invest");
    Route::get('/User/Childe/{id}/CashOut',[\App\Http\Controllers\UserController::class, 'CashOut'])->name("Childe-Cashout");
    Route::get('/User/{id}',[\App\Http\Controllers\UserController::class, 'edit'])->name("User-Edit");
    Route::post('/User/{id}',[\App\Http\Controllers\UserController::class, 'update'])->name("User-Update");
    Route::get('/Budget',[\App\Http\Controllers\BudgetController::class, 'index'])->name("Budget");
    Route::resource('/Budges', \App\Http\Controllers\BadgesController::class);
    Route::get('/Budges/Question/{id}',[\App\Http\Controllers\QuestionController::class, 'index'])->name('Budges.Question');
    Route::get('/Budges/Question/Add/{badges_id}', [\App\Http\Controllers\QuestionController::class, 'AddQuestion'])->name('Budges.Question.Add');
    Route::post('/Budges/Question/Add/{badges_id}', [\App\Http\Controllers\QuestionController::class, 'StoreQuestion'])->name('Budges.Question.Store');
    Route::get('/Budges/Question/Edit/{question_id}', [\App\Http\Controllers\QuestionController::class, 'EditQuestion'])->name('Budges.Question.Edit');
    Route::post('/Budges/Question/Edit/{question_id}', [\App\Http\Controllers\QuestionController::class, 'UpdateQuestion'])->name('Budges.Question.Update');
    Route::get('/Budges/Question/Delete/{question_id}', [\App\Http\Controllers\QuestionController::class, 'SoftDeleteQuestion'])->name('Budges.Question.Delete');
    Route::get('/Invest',[\App\Http\Controllers\InvestController::class, 'index'])->name('invest');
    Route::get('/CashOut',[\App\Http\Controllers\CashOutController::class, 'index'])->name('CashOut');
    Route::get('/tooth-reward-setting',[\App\Http\Controllers\ToothRewardController::class, 'index'])->name('tooth-reward-setting');
    Route::post('/reward-save',[\App\Http\Controllers\ToothRewardController::class, 'update'])->name("reward-save");
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('sendtest',[\App\Http\Controllers\SendMailController::class, 'send']);

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
