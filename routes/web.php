<?php

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
})->name('root');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

//Routes with Role Middleware

Route::middleware(['auth'])->group(function () {

//Roles
	Route::post('roles/store', 'RoleController@store')->name('roles.store')
		->middleware('can:roles.create');

	Route::get('roles', 'RoleController@index')->name('roles.index')
		->middleware('can:roles.index');

	Route::get('roles/create', 'RoleController@create')->name('roles.create')
		->middleware('can:roles.create');

	Route::put('roles/{role}', 'RoleController@update')->name('roles.update')
		->middleware('can:roles.edit');

	Route::get('roles/{role}', 'RoleController@show')->name('roles.show')
		->middleware('can:roles.show');

	Route::delete('roles/{role}', 'RoleController@destroy')->name('roles.destroy')
		->middleware('can:roles.destroy');

	Route::get('roles/{role}/edit', 'RoleController@edit')->name('roles.edit')
		->middleware('can:roles.edit');
//Users
	Route::get('users/export/', 'UserController@exportXlsx');
	Route::get('users/pdf/', 'UserController@exportPDF');

	Route::get('users', 'UserController@index')->name('users.index')
		->middleware('can:users.index');

	Route::post('users/store', 'UserController@store')->name('users.store')
		->middleware('can:users.create');

	Route::get('users/trash', 'UserController@trash')->name('users.trash')
		->middleware('can:users.trash');

	Route::get('users/create', 'UserController@create')->name('users.create')
		->middleware('can:users.create');

	Route::put('users/{user}', 'UserController@update')->name('users.update')
		->middleware('can:users.edit');

	Route::get('users/{user}', 'UserController@show')->name('users.show')
		->middleware('can:users.show');

	Route::get('/users/restore/{id}', 'UserController@restore')->name('users.restore')
		->middleware('can:users.restore');

	Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy')
		->middleware('can:users.destroy');

	Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit')
		->middleware('can:users.edit');

	//Settings

	Route::get('settings', 'SettingController@index')->name('settings.index')
		->middleware('can:settings.index');

	Route::get('settings/create', 'SettingController@create')->name('settings.create')
		->middleware('can:settings.create');

	Route::put('settings/{setting}', 'SettingController@update')->name('settings.update')
		->middleware('can:settings.edit');

	Route::get('settings/{setting}/edit', 'SettingController@edit')->name('settings.edit')
		->middleware('can:settings.edit');

	Route::post('settings/store', 'SettingController@store')->name('settings.store')
		->middleware('can:settings.create');

	Route::delete('settings/{setting}', 'SettingController@destroy')->name('settings.destroy')
		->middleware('can:settings.destroy');

	//Patient
	Route::get('patients/export/', 'PatientController@exportXlsx')->name('export');
	Route::get('patients/pdf/', 'PatientController@exportPDF')->name('pdf');

	Route::get('patients', 'PatientController@index')->name('patients.index')
		->middleware('can:patients.index');


	Route::get('patients/create', 'PatientController@create')->name('patients.create')
		->middleware('can:patients.create');

	Route::get('patients/trash', 'PatientController@trash')->name('patients.trash')
		->middleware('can:patients.trash');

	Route::put('patients/{patient}', 'PatientController@update')->name('patients.update')
		->middleware('can:patients.edit');

	Route::get('patients/{patient}/edit', 'PatientController@edit')->name('patients.edit')
		->middleware('can:patients.edit');

	Route::get('patients/{patient}', 'PatientController@show')->name('patients.show')
		->middleware('can:patients.show');

	Route::post('patients/store', 'PatientController@store')->name('patients.store')
		->middleware('can:patients.create');

	Route::delete('patients/{patient}', 'PatientController@destroy')->name('patients.destroy')
		->middleware('can:patients.destroy');

	Route::get('/patients/restore/{id}', 'PatientController@restore')->name('patients.restore')
		->middleware('can:patients.restore');

    // Assitant

    Route::get('assistants', 'AssistantController@index')->name('assistants.index')
        ->middleware('can:assistants.index');

    Route::post('assistants/store', 'AssistantController@store')->name('assistants.store')
        ->middleware('can:assistants.create');

    Route::get('assistants/trash', 'AssistantController@trash')->name('assistants.trash')
        ->middleware('can:assistants.trash');

    Route::get('assistants/create', 'AssistantController@create')->name('assistants.create')
        ->middleware('can:assistants.create');

    Route::put('assistants/{assistant}', 'AssistantController@update')->name('assistants.update')
        ->middleware('can:assistants.edit');

    Route::get('assistants/{user}', 'AssistantController@show')->name('assistants.show')
        ->middleware('can:assistants.show');

    Route::get('/assistants/restore/{assistant}', 'AssistantController@restore')->name('assistants.restore')
        ->middleware('can:assistants.restore');

    Route::delete('assistants/{assistant}', 'AssistantController@destroy')->name('assistants.destroy')
        ->middleware('can:assistants.destroy');

    Route::get('assistants/{assistant}/edit', 'AssistantController@edit')->name('assistants.edit')
        ->middleware('can:assistants.edit');

	// Events
    //fullcalender
	Route::get('/events','EventController@index')->name('events.index');
	Route::post('/events/create','EventController@create')->name('events.create');
	Route::post('/events/update','EventController@update')->name('events.update');
	Route::post('/events/delete','EventController@destroy')->name('events.destroy');


	// Consultations

    Route::get('consultations', 'ConsultationController@index')->name('consultations.index')
        ->middleware('can:consultations.index');

    Route::post('consultations/store', 'ConsultationController@store')->name('consultations.store')
        ->middleware('can:consultations.create');

    Route::get('consultations/trash', 'ConsultationController@trash')->name('consultations.trash')
        ->middleware('can:consultations.trash');

    Route::get('consultations/create', 'ConsultationController@create')->name('consultations.create')
        ->middleware('can:consultations.create');

    Route::put('consultations/{consultation}', 'ConsultationController@update')->name('consultations.update')
        ->middleware('can:consultations.edit');

    Route::get('consultations/{consultation}', 'ConsultationController@show')->name('consultations.show')
        ->middleware('can:consultations.show');

    Route::get('consultations/restore/{consultation}', 'ConsultationController@restore')->name('consultations.restore')
        ->middleware('can:consultations.restore');

    Route::delete('consultations/{consultation}', 'ConsultationController@destroy')->name('consultations.destroy')
        ->middleware('can:consultations.destroy');

    Route::get('consultations/{consultation}/edit', 'ConsultationController@edit')->name('consultations.edit')
        ->middleware('can:consultations.edit');

    Route::post('consultations/search','ConsultationController@search')->name('consultations.search');

    Route::delete('consultations/{consultation}', 'ConsultationController@destroy')->name('consultations.destroy')
        ->middleware('can:consultations.destroy');

    Route::get('/consultations/restore/{id}', 'ConsultationController@restore')->name('consultations.restore')
        ->middleware('can:consultations.restore');

});
