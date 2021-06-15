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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\TelaController@master')->name('tela.master');


Route::get('/{guiche_id}/chamar', 'App\Http\Controllers\TelaController@chamar')->name('tela.chamar');
Route::get('/{guiche_id}/repetir', 'App\Http\Controllers\TelaController@repetir')->name('tela.repetir');
Route::get('/anteriores', 'App\Http\Controllers\TelaController@anteriores')->name('tela.anteriores');
Route::get('/atual', 'App\Http\Controllers\TelaController@atual')->name('tela.atual');

Route::prefix('guiches')->group(function(){
    Route::get('/', 'App\Http\Controllers\GuichesController@index')->name('guiches.index');
    Route::get('/create', 'App\Http\Controllers\GuichesController@create')->name('guiches.create');
    Route::post('/store', 'App\Http\Controllers\GuichesController@store')->name('guiches.store');
    Route::get('/{id}/edit', 'App\Http\Controllers\GuichesController@edit')->name('guiches.edit');
    Route::put('/update', 'App\Http\Controllers\GuichesController@update')->name('guiches.update');
    //Route::get('/create', 'App\Http\Controllers\HorariosController@create')->name('horarios.create');
});
