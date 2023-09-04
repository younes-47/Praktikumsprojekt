<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\SalleController;

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


Route::get('/accueil', 'App\Http\Controllers\LoginController@home')->middleware('auth');
Route::get('/', 'App\Http\Controllers\LoginController@index');
Route::get('/login', 'App\Http\Controllers\LoginController@index');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout')->middleware('auth');
Route::post('/connection', 'App\Http\Controllers\LoginController@checklogin');
Route::get('/connection', 'App\Http\Controllers\LoginController@index');
Route::post('/changer_password', 'App\Http\Controllers\LoginController@changer_password')->name('changer_password')->middleware('auth');
Route::post('/changer_username', 'App\Http\Controllers\LoginController@changer_username')->name('changer_username')->middleware('auth');

Route::resource('employee', EmployeeController::class)->middleware('auth'); 
Route::get('/employee', 'App\Http\Controllers\EmployeeController@index')->middleware('auth');
Route::get('/employee/supprimer/{id}', 'App\Http\Controllers\EmployeeController@supprimer')->name('employee.supprimer')->middleware('auth');


Route::resource('salle', SalleController::class)->middleware('auth');
Route::get('/salle', 'App\Http\Controllers\SalleController@index')->middleware('auth');
Route::get('/salle/supprimer/{id}', 'App\Http\Controllers\SalleController@supprimer')->name('salle.supprimer')->middleware('auth');

Route::resource('equipement', EquipementController::class)->middleware('auth');
Route::get('/equipement', 'App\Http\Controllers\EquipementController@index')->middleware('auth');
Route::get('/equipement/supprimer/{id}', 'App\Http\Controllers\EquipementController@supprimer')->name('equipement.supprimer')->middleware('auth');



//Archive
Route::get('/archive', 'App\Http\Controllers\ArchiveController@selection')->name('selection')->middleware('auth');
Route::get('/archive/employes', 'App\Http\Controllers\ArchiveController@employee')->name('archive-employees')->middleware('auth');
Route::get('/archive/employe/{id}', 'App\Http\Controllers\ArchiveController@historique')->name('archive-employee')->middleware('auth');
Route::get('/archive/employe/{id}/restauration', 'App\Http\Controllers\ArchiveController@employe_restauration_page')->name('page-restauration-employe')->middleware('auth');
Route::put('/archive/employe/{id}/restaurer', 'App\Http\Controllers\ArchiveController@restaurer_employe')->name('restaurer-employe')->middleware('auth');

Route::get('/archive/equipements', 'App\Http\Controllers\ArchiveController@equipements')->name('archive-equipements')->middleware('auth');
Route::get('/archive/equipement/{id}/restauration', 'App\Http\Controllers\ArchiveController@equipement_restauration_page')->name('page-restauration-equipement')->middleware('auth');
Route::put('/archive/equipement/{id}/restaurer', 'App\Http\Controllers\ArchiveController@restaurer_equipement')->name('restaurer-equipement')->middleware('auth');

