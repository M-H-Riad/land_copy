<?php

Route::group(['module' => 'User','namespace' => 'App\Modules\User\Controllers'], function() {
    Route::get('passwords/reset/{token}', ['as' => 'password_reset', 'uses' => 'UserController@showResetForm']);
    Route::post('password/update', ['as' => 'password_update', 'uses' => 'UserController@userPasswordUpdate']);

});
Route::group(['module' => 'User', 'middleware' => ['web', 'auth','auditTrails','permission:manage_role'], 'namespace' => 'App\Modules\User\Controllers'], function() {
    Route::resource('permission', 'PermissionController');
    Route::resource('role', 'RoleController');
    Route::resource('role-user', 'RoleUserController');
    Route::any('user-list', ['as' => 'user-list', 'uses' => 'UserController@index_user']);
    Route::any('edit-user/{id}', ['as' => 'edit-user', 'uses' => 'UserController@edit_user']);
    Route::any('update-user/{id}', ['as' => 'update-user', 'uses' => 'UserController@update_user']);


});
Route::group(['module' => 'User', 'middleware' => ['web', 'auth','auditTrails'], 'namespace' => 'App\Modules\User\Controllers'], function() {

    Route::post('change-password','UserController@change_password');
    Route::post('user/get-data', ['as' => 'user.get-data', 'uses' => 'UserController@getData']);
    Route::get('user/structure', ['as' => 'user.structure', 'uses' => 'UserController@structure']);
    Route::get('user/profile', ['as' => 'profile', 'uses' => 'UserController@profile']);
    Route::get('user/profile/edit', ['as' => 'profile.edit', 'uses' => 'UserController@edit']);
    Route::resource('user', 'UserController');

    Route::get('register', ['as' => 'register', 'uses' => 'UserController@register']);
    Route::post('register-create', ['as' => 'register-create', 'uses' => 'UserController@register_create']);

    Route::resource('designation', 'DesignationController');
    Route::resource('department', 'DepartmentController');
 
});

Route::group(['module' => 'User', 'middleware' => ['web'], 'namespace' => 'App\Modules\User\Controllers'], function() {
Route::get('user-activation/{id}', ['as' => 'user_activation', 'uses' => 'UserController@user_activation']);
});



