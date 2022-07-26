<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ModeController;
use App\Http\Controllers\Api\LicensePlatesController;
use App\Http\Controllers\Api\SourceController;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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

Route::middleware('auth:api')->get('/userLogged', function (Request $request) {
    return response()->json(['status' => 1, 'user' => $request->user()]);
});

Route::get('/test', function(){
    return response()->json(['status' => 1, 'value' => 'Test']);
});

Route::group(['middleware' => ['auth:api'/*, 'throttle:time'*/]], function(){
    Route::get('users', [UserController::class, 'users'])->name('users');
    Route::get('user', [UserController::class, 'user'])->name('user');
    Route::get('users/modes', [UserController::class, 'modes'])->name('modes');
    Route::get('users/roles', [UserController::class, 'roles'])->name('roles');
    Route::post('user/change/mode', [UserController::class, 'modifyMode'])->name('modifyMode');
    Route::post('user/delete', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::post('user/change/email', [UserController::class, 'editUserEmail'])->name('editUserEmail');
    Route::post('user/change/password', [UserController::class, 'editUserPassword'])->name('editUserPassword');
    Route::post('user/change/token', [UserController::class, 'changeApiToken'])->name('changeApiToken');

    Route::get('modes', [ModeController::class, 'modes'])->name('modes');
    Route::post('mode/create', [ModeController::class, 'createMode'])->name('createMode');
    Route::post('mode/delete', [ModeController::class, 'deleteMode'])->name('deleteMode');

    Route::get('lists', [LicensePlatesController::class, 'lists'])->name('lists');
    Route::get('list/plates', [LicensePlatesController::class, 'platesInList'])->name('platesInList');
    Route::get('1/plate', [LicensePlatesController::class, 'plateMode1'])->name('plateMode1');
    Route::get('2/plate', [LicensePlatesController::class, 'plateMode2'])->name('plateMode2');
    Route::get('3/plate', [LicensePlatesController::class, 'plateMode3'])->name('plateMode3');
    Route::get('4/plate', [LicensePlatesController::class, 'plateMode4'])->name('plateMode4');
    Route::get('plate/list', [LicensePlatesController::class, 'listOfPlate'])->name('listOfPlate');
    Route::post('list/create', [LicensePlatesController::class, 'createList'])->name('createList');
    Route::post('plate/list/add', [LicensePlatesController::class, 'addPlateToList'])->name('addPlateToList');
    Route::post('plate/list/remove', [LicensePlatesController::class, 'removePlateFromList'])->name('removePlateFromList');
    Route::post('list/delete', [LicensePlatesController::class, 'deleteList'])->name('deleteList');

    Route::get('sources', [SourceController::class, 'sources'])->name('sources');
    Route::post('source/1/create', [SourceController::class, 'createSourceMode1'])->name('createSourceMode1');
    Route::post('source/2/create', [SourceController::class, 'createSourceMode2'])->name('createSourceMode2');
    Route::post('source/3/create', [SourceController::class, 'createSourceMode3'])->name('createSourceMode3');
    Route::post('source/4/create', [SourceController::class, 'createSourceMode4'])->name('createSourceMode4');
    Route::post('source/1/edit', [SourceController::class, 'editSourceMode1'])->name('editSourceMode1');
    Route::post('source/2/edit', [SourceController::class, 'editSourceMode2'])->name('editSourceMode2');
    Route::post('source/3/edit', [SourceController::class, 'editSourceMode3'])->name('editSourceMode3');
    Route::post('source/4/edit', [SourceController::class, 'editSourceMode4'])->name('editSourceMode4');
    Route::post('source/1/delete', [SourceController::class, 'deleteSourceMode1'])->name('deleteSourceMode1');
    Route::post('source/2/delete', [SourceController::class, 'deleteSourceMode2'])->name('deleteSourceMode2');
    Route::post('source/3/delete', [SourceController::class, 'deleteSourceMode3'])->name('deleteSourceMode3');
    Route::post('source/4/delete', [SourceController::class, 'deleteSourceMode4'])->name('deleteSourceMode4');
});

Route::post('user/register', [UserController::class, 'registerCompany'])->name('registerCompany');
Route::post('user/login', [UserController::class, 'login'])->name('login');


#####################
### RATE LIMITERS ###
#####################

/*
RateLimiter::for('time', function (Request $request) {
    if($request->user()->is_admin == 1){
        return Limit::none();
    }
    else{
        return Limit::perDay(4);
    }
});
*/