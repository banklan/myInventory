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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//admin routes
Route::get('/admin', 'AdminController@index')->name('admin.home');
Route::get('/admin-login', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin-login', 'Admin\LoginController@login');
Route::post('/admin-password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('/admin-password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('/admin-password/reset', 'Admin\ResetPasswordController@reset');
Route::get('/admin-password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::get('/admin/all_users', 'AdminController@index');
Route::get('/admin/admins/{id}', 'AdminController@index');
Route::get('/admin/front_office/{id}', 'AdminController@index');
Route::get('/admin/supervisor/{id}', 'AdminController@index');
// Route::get('/admin/test', 'AdminController@index');
// Route::get('/admin/sidenav', 'AdminController@index');
// Route::get('/admin/sidenav2', 'AdminController@index');
Route::get('/admin/users/all_admins', 'AdminController@index');
Route::get('/admin/users/all_supervisors', 'AdminController@index');
Route::get('/admin/users/all_sales', 'AdminController@index');
Route::get('/admin/roles', 'AdminController@index');
Route::get('/admin/inventory', 'AdminController@index');
Route::get('/admin/settings', 'AdminController@index');
Route::get('/admin/user_search_result', 'AdminController@index');
Route::get('/admin/products/products', 'AdminController@index');
Route::get('/admin/products/categories', 'AdminController@index');
Route::get('/admin/products/product/{id}', 'AdminController@index');
// Route::get('/admin/front_office/{id}', 'AdminController@index');

//api calls for admin
Route::get('/getadmins', 'AdminController@getAdmins');
Route::get('/getusers', 'AdminController@getUsers');
Route::get('/getallsupervisors', 'AdminController@getAllSupervisors');
Route::get('/getadminuser/{id}', 'AdminController@getAdminUser');
Route::get('/getfrontofficeuser/{id}', 'AdminController@getFrontOfficeUser');
Route::get('/getsupervisoruser/{id}', 'AdminController@getSupervisorUser');
Route::post('/update_admin_user/{id}', 'AdminController@updateAdminUser');
Route::post('/enable_admin/{id}', 'AdminController@enableAdminUser');
Route::post('/disable_admin/{id}', 'AdminController@disableAdminUser');
Route::post('/enable_user/{id}', 'AdminController@enableUser');
Route::post('/disable_user/{id}', 'AdminController@disableUser');
Route::post('/enable_supervisor/{id}', 'AdminController@enableSupervisor');
Route::post('/disable_supervisor/{id}', 'AdminController@disableSupervisor');
Route::post('/reset_adminpswd/{id}', 'AdminController@resetAdminPswd');
Route::post('/reset_userpswd/{id}', 'AdminController@resetUserPswd');
Route::post('/reset_supervisorpswd/{id}', 'AdminController@resetSupervisorPswd');
Route::post('/del_admin/{id}', 'AdminController@delAdmin');
Route::post('/del_user/{id}', 'AdminController@delUser');
Route::post('/del_supervisor/{id}', 'AdminController@delSupervisor');
Route::post('/create_newuser', 'AdminController@createNewUser');
Route::post('/create_newsupervisor', 'AdminController@createNewSupervisor');
Route::post('/create_newadmin', 'AdminController@createNewAdmin');
Route::post('/update_admin_frontoffice/{id}', 'AdminController@updateFrontOfficeUser');
Route::post('/update_admin_supervisor/{id}', 'AdminController@updateAdminSupervisor');
Route::post('/adminsearch_admin', 'AdminController@AdminSearchAdmin');
Route::post('/create_admin', 'AdminController@AdminCreateAdmin');
Route::post('/admin_deleteuser/{id}', 'AdminController@AdminDelUser');
Route::post('/admin_updateusers/{id}', 'AdminController@AdminUpdateUser');
Route::post('/create_sup', 'AdminController@AdminCreateSup');
Route::post('/create_user', 'AdminController@AdminCreateUser');
Route::get('/getroles', 'AdminController@getRoles');
Route::post('/admin_delrole/{id}', 'AdminController@AdminDelRole');
Route::post('/create_role', 'AdminController@AdminCreateRole');
Route::post('/admin_updaterole/{id}', 'AdminController@AdminUpdateRole');
Route::get('/getsinglerole/{id}', 'AdminController@GetSingleRole');
Route::get('/admin_getcategs', 'AdminTablesController@AdminGetCategs');
Route::post('/admin_createcateg', 'AdminTablesController@AdminCreateCateg');
Route::post('/admin_updatecateg/{id}', 'AdminTablesController@AdminUpdateCateg');
Route::post('/admin_delcat/{id}', 'AdminTablesController@AdminDelCateg');
Route::get('/admin_getproducts', 'AdminTablesController@AdminGetProducts');
Route::post('/admin_createproduct', 'AdminTablesController@AdminCreateProduct');
Route::get('/admin_viewproduct/{id}', 'AdminTablesController@AdminGetProduct');
Route::post('/admin_delprod/{id}', 'AdminTablesController@AdminDelProduct');
Route::post('/admin_updateproduct/{id}', 'AdminTablesController@AdminUpdateProduct');
Route::get('/getUser', 'AdminTablesController@findAdmin');
Route::get('/get_adminprofile', 'AdminTablesController@getProfile');
Route::post('/admin_updateprofile', 'AdminTablesController@adminUpdateProfile');
Route::post('/admin_checkpswd', 'AdminTablesController@adminCheckPswd');
Route::post('/admin_changepswd', 'AdminTablesController@adminChangePswd');


//supervisor routes
Route::get('/supervisor', 'SupervisorController@index')->name('supervisor.home');
Route::get('/supervisor-login', 'Supervisor\LoginController@showLoginForm')->name('supervisor.login');
Route::post('/supervisor-login', 'Supervisor\LoginController@login');
Route::post('/supervisor-password/email', 'Supervisor\ForgotPasswordController@sendResetLinkEmail')->name('supervisor.password.email');
Route::get('/supervisor-password/reset', 'Supervisor\ForgotPasswordController@showLinkRequestForm')->name('supervisor.password.request');
Route::post('/supervisor-password/reset', 'Supervisor\ResetPasswordController@reset');
Route::get('/supervisor-password/reset/{token}', 'Supervisor\ResetPasswordController@showResetForm')->name('supervisor.password.reset');
Route::get('/supervisor/stocks/all_stocks', 'SupervisorController@index');
Route::get('/supervisor/stocks/new_stock', 'SupervisorController@index');
Route::get('/supervisor/add_stock/{id}', 'SupervisorController@index');
Route::get('/supervisor/stocks/search', 'SupervisorController@index');
Route::get('/supervisor/all_products', 'SupervisorController@index');
Route::get('/supervisor/product/search', 'SupervisorController@index');
Route::get('/supervisor/product/{id}', 'SupervisorController@index');
Route::get('/supervisor/settings', 'SupervisorController@index');

// supervisors api call
Route::get('/getcategs', 'SupervisorController@getCategs');
Route::get('/sup_getproductsfromcateg/{id}', 'SupervisorController@getproductsFromCateg');
// Route::post('/sup_addnewstock', 'SupervisorController@supAddNewStock');
Route::get('/sup_getallproducts', 'SupervisorController@supGetProducts');
Route::post('/sup_add_new_stock/{id}', 'SupervisorController@supAddNewStocks');
Route::get('/sup_getproduct/{id}', 'SupervisorController@supGetProduct');
Route::post('/sup_searchproduct', 'SupervisorController@searchProduct');
Route::post('/sup_updateproduct/{id}', 'SupervisorController@updateProduct');
Route::get('/sup_getprofile', 'SupervisorController@getSupervisorProfile');
Route::post('/sup_changepswd', 'SupervisorController@SupChangePswd');
Route::post('/sup_checkpswd', 'SupervisorController@SupCheckPswd');
Route::post('/sup_updateprofile', 'SupervisorController@updateProfile');
