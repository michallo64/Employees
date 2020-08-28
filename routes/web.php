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
Route::get('/home', "EmployeesController@home")->name('home');
Route::get('/employees', 'EmployeesController@index')->name('employees');
Route::post('/employees/edit', 'EmployeesController@edit')->name('employee.edit');
Route::get('/employees/delete/{id}', 'EmployeesController@delete')->name('employee.delete');
Route::post('/employees', 'EmployeesController@create')->name('employee.create');
Route::post('/employee/{id}', 'EmployeesController@getData');

