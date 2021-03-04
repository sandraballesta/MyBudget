<?php

use App\Http\Controllers\PassportController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
    //return $request->user();
//});

Route::post('login', [PassportController::class, 'login']);
Route::post('register', [PassportController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('user', [PassportController::class,'details']);

    Route::post('create-post', [\App\Http\Controllers\post::class, 'create_post']);
    Route::get('get-post', [\App\Http\Controllers\post::class, 'get_posts']);

    //get all the information of month table by id
    Route::get('months/{id}', [\App\Http\Controllers\MonthsController::class, 'month_by_id']);
    //update column expenses by id
    Route::put('months/{id}/{exp}', [\App\Http\Controllers\MonthsController::class, 'add_expense']);
    //get all the information of month table
    Route::get('months', [\App\Http\Controllers\MonthsController::class, 'get_months']);
    //change the dailyBudget value
    Route::put('months/day/{id}/{budget}', [\App\Http\Controllers\MonthsController::class, 'dailyBudget']);


    Route::post('goals/{id}', [\App\Http\Controllers\GoalsController::class, 'new_goal']);

    Route::get('goals/{id}', [\App\Http\Controllers\GoalsController::class, 'get_goals']);

    Route::put('goals/{id}/{dailyBudget}', [\App\Http\Controllers\GoalsController::class, 'update_goal']);

    Route::post('months', [\App\Http\Controllers\MonthsController::class, 'create_month']);

    //Route::get('goals', [\App\Http\Controllers\MonthsController::class, 'get_months']);

    Route::resource('products', 'ProductController');
});
