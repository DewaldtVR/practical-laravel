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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Auth::routes();
Auth::routes(['verify' => true]);
Route::get('/', function () {
    return view('welcome');
});

Route::group(["middleware" => ["auth", "state"]], function () {
    Route::post('/email/verification-notification', "Auth\VerificationController@sendResetLink")->name('account.verification.send');
});

Route::group(["middleware" => ["state"]], function () {
    Route::get('/web-contents/{web_content_slug}', "WebcontentController@render")->name('webcontents.get');
    Route::get('/registration', 'Auth\RegisterController@index')->name('public.registration'); // Register user as public access
});

Route::group(["middleware" => ["auth", "state", "verified"]], function () {

    Route::group(["middleware" => ["mainmenu"]], function () {

        //Route for general file serving
        Route::get('/files/{file}', 'FileController@serveFile')->name('files.serve');

        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/profile', 'UserController@profile')->name('profile');

        Route::group(["middleware" => ["right:user_management"]], function () {
            Route::get('/roles', 'RoleController@index')->name('roles.list');
            Route::post('/roles', 'RoleController@tableDataProvider')->name('roles.data');

            Route::get('/roles/{userrole}/rights', 'RoleController@getRights');
            Route::post('/roles/{userrole}/rights', 'RoleController@updateRoleRights');

            Route::get('/users', 'UserController@index')->name('users.list');
            Route::post('/users', 'UserController@tableDataProvider')->name('users.data');

            Route::get('/users/deactivated', 'UserController@deactivatedIndex')->name('users.deactivated.list');
            Route::post('/users/deactivated', 'UserController@deactivatedTableDataProvider')->name('users.deactivated.data');

            Route::post('/users/{userid}/deactivate', 'UserController@deactivateUser');
            Route::post('/users/{userid}/activate', 'UserController@activateUser');
            Route::get('/users/extractusers', 'UserController@extractusers');

            Route::get('/users/{user}/rights', 'UserController@getUserRights');
            Route::post('/users/{user}/rights', 'UserController@updateUserRights');

            Route::get('/users/{user}/roles', 'UserController@getUserRoles');
            Route::post('/users/{user}/roles', 'UserController@updateUserRoles');
        });

        Route::post('/users/{user}', 'UserController@profileUpdateDetails')->name('profile.details');
        Route::post('/users/{user}/password', 'UserController@profileUpdatePassword')->name('profile.password');

        Route::group(["middleware" => ["right:client_management"]], function () {

            Route::get('/clients', 'ClientController@index')->name('clients.list');
            Route::post('/clients', 'ClientController@tableDataProvider')->name('clients.data');
            Route::get('/clients/{client}/contacts', 'ContactController@index')->name('contacts.list');
            Route::post('/clients/{client}/contacts', 'ContactController@tableDataProvider')->name('contacts.data');

        });
        
        Route::group(["middleware" => ["right:contacts_management"]], function () {

            Route::get('/contact', 'ContactController@report')->name('contacts.list');
            Route::post('/contact', 'ContactController@tableDataProvider')->name('contacts.data');
             Route::get('/contact/{contact}/clients', 'ClientController@index')->name('clients.list');
            Route::post('/contact/{contact}/clients', 'ClientController@tableDataProvider')->name('clients.data');

        });

        Route::group(["middleware" => ["right:setting_management"]], function () {
            Route::get('/settings', 'SettingController@index')->name('settings.list');
            Route::post('/settings', 'SettingController@tableDataProvider')->name('settings.data');
        });

       
    });
});
