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

// Route::get('/{any}', function () {
//     return view('welcome');
// });
// Route::get('/', function () {
//     return view('vue');
// });

// Route::get('/getConnect','Controller@index')->name('userlist');

// Route::get('/getConnect', [Controller::class, 'index']);
// Route::get('/getConnect', 'App\Http\Controllers\Controller@index');

Route::get('/{any}', function () {
    return view('vue');
  })->where('any', '.*');

//   Route::get('/getConnect', 'Controller@getInvMPList')->where('name', '.*');

