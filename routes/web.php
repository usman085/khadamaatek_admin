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
// Route::get('/testing',function(){
// 	return  Session::put('variableName', "2");
// 	});
// Route::get('/testing-get',function(){
// 	return Session::get('variableName');
	
// });

Route::get('/set/locale/{locale}', "UsersController@setLocale")->name('set.locale');
Route::group(['prefix' => 'admin'], function () {
    Auth::routes();
    Route::post('check',  "Auth\LoginController@doLogin")->name('check.admin');
    // Route::post('log-out',  "Auth\LoginController@doLogout")->name('logout.admin');
});
Route::group(['middleware' => ['get.menu','setLocalSession']], function () {

    Route::post('customer/email-verify-send/{id}',      "API\CustomerController@verifyEmailSend");
    

    Route::group(['middleware' => ['check.role'], 'prefix' => 'admin'], function () {
        Route::get('/', "DashboardController@index");
        Route::get('/dashboard', "DashboardController@index")->name('dashboard');
        // Route::resource('users',        'UsersController')->except(['create', 'store']);
        Route::resource('users',        'UsersController');
        Route::get('/profile', "UsersController@profile")->name('user.profile');
        Route::post('/update-profile', "UsersController@updateProfile")->name('user.updateprofile');
        Route::post('/update-bank-detail', "UsersController@updateBankDetails")->name('user.updatebankdetail');

        Route::resource('roles',            'RolesController');
        Route::resource('groups',           'GroupController');
        Route::resource('customers',        'CustomerController');
        Route::get('/customer-requests',    'CustomerController@customerRequests')->name('customer.requests');
        Route::get('customer/logs',         'CustomerController@logReport')->name('customer.logs');
        Route::get('customer/fetch-logs',   'CustomerController@fetchLogReport')->name('customer.fetchlogs');
        Route::get('/chane-request-status/{id}/{status}', 'CustomerController@changeRequestStatus')->name('change.requeststatus');

        Route::resource('documents', 'DocumentController');
        //Report Controller    
        Route::get('/sales-report',                          "ReportController@index")->name('report.index');
       
        // Form Builder
        Route::get('/requirement-template',                          "FormBuilderController@index")->name('forms.index');
        Route::get('/requirement-template/create',                   "FormBuilderController@create")->name('forms.create');
        Route::POST('/requirement-template/store',                   'FormBuilderController@store')->name('forms.store');
        Route::GET('/requirement-template/{template}/edit',          'FormBuilderController@edit')->name('forms.edit');
        Route::PUT('/requirement-template/update/{template}',        'FormBuilderController@update')->name('forms.update');
        Route::GET('/requirement-template/{template}',               'FormBuilderController@show')->name('forms.show');
        Route::delete('/requirement-template/destroy/{template}',    'FormBuilderController@destroy')->name('forms.destroy');

        // Service Categories
        Route::get('/service-categories', 'CategoriesController@index')->name('category.index');
        Route::get('/service-category/create', 'CategoriesController@create')->name('category.create');
        Route::POST('/service-category/store', 'CategoriesController@store')->name('category.store');
        Route::GET('/service-category/{id}/edit', 'CategoriesController@edit')->name('category.edit');
        Route::PUT('/service-category/update/{id}', 'CategoriesController@update')->name('category.update');
        Route::GET('/service-category/view-child/{id}', 'CategoriesController@view_child')->name('category.childs');
        Route::delete('/service-category/destroy/{id}', 'CategoriesController@destroy')->name('category.destroy');
        Route::get('/service-category/get-sub-categories/{category}', 'CategoriesController@getSubCategories')->name('category.subcategories');
        Route::get('/department/get-categories/{department}', 'DepartmentController@getCategories')->name('department.category');

        // Department
        Route::get('/departments', 'DepartmentController@index')->name('department.index');
        Route::get('/department/create', 'DepartmentController@create')->name('department.create');
        Route::POST('/department/store', 'DepartmentController@store')->name('department.store');
        Route::GET('/department/{department}/edit', 'DepartmentController@edit')->name('department.edit');
        Route::PUT('/department/update/{department}', 'DepartmentController@update')->name('department.update');
        Route::delete('/department/destroy/{department}', 'DepartmentController@destroy')->name('department.destroy');

        // Service
        Route::get('/services', 'ServiceController@index')->name('service.index');
        Route::get('/service/create', 'ServiceController@create')->name('service.create');
        Route::POST('/service/store', 'ServiceController@store')->name('service.store');
        Route::GET('/service/{service}/edit', 'ServiceController@edit')->name('service.edit');
        Route::PUT('/service/update/{service}', 'ServiceController@update')->name('service.update');
        Route::delete('/service/destroy/{service}', 'ServiceController@destroy')->name('service.destroy');

        // Orders
        Route::get('/orders', 'OrderController@index')->name('order.index');
        Route::GET('/order/{order}/edit', 'OrderController@edit')->name('order.edit');
        Route::PUT('/order/update/{order}', 'OrderController@update')->name('order.update');
        Route::delete('/order/destroy/{order}', 'OrderController@destroy')->name('order.destroy');
        Route::post('order/fetch-transaction', "OrderController@fetchTransaction")->name('fetch.transaction');
        Route::post('order/fetch-requirements', "OrderController@fetchRequirements")->name('fetch.requirements');
        Route::post('order/fetch-messages', "OrderController@fetchMessages")->name('fetch.messages');
        Route::post('message/send-message', "OrderController@sendMessage")->name('send.message');
        Route::post('transaction/update-status', "OrderController@updateTransactionStatus")->name('transaction.update_status');
        Route::POST('/order/getdetail', 'OrderController@getOrder')->name('fetch.orderdetail');
        // Route::PUT('/order/update_status/{order}', 'OrderController@update_status')->name('order.update_status');

        // Transaction
        Route::get('/transactions', 'TransactionController@index')->name('transaction.index');
        Route::GET('/transaction/{transaction}/edit', 'TransactionController@edit')->name('transaction.edit');
        Route::PUT('/transaction/update/{transaction}', 'TransactionController@update')->name('transaction.update');
        Route::delete('/transaction/destroy/{transaction}', 'TransactionController@destroy')->name('transaction.destroy');

        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
        Route::prefix('menu/element')->group(function () {
            Route::get('/',             'MenuElementController@index')->name('menu.index');
            Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
            Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
            Route::get('/create',       'MenuElementController@create')->name('menu.create');
            Route::post('/store',       'MenuElementController@store')->name('menu.store');
            Route::get('/get-parents',  'MenuElementController@getParents');
            Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
            Route::post('/update',      'MenuElementController@update')->name('menu.update');
            Route::get('/show',         'MenuElementController@show')->name('menu.show');
            Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
        });
        Route::prefix('menu/menu')->group(function () {
            Route::get('/',         'MenuController@index')->name('menu.menu.index');
            Route::get('/create',   'MenuController@create')->name('menu.menu.create');
            Route::post('/store',   'MenuController@store')->name('menu.menu.store');
            Route::get('/edit',     'MenuController@edit')->name('menu.menu.edit');
            Route::post('/update',  'MenuController@update')->name('menu.menu.update');
            Route::get('/delete',   'MenuController@delete')->name('menu.menu.delete');
        });
    });
});


Route::get('verify-message/{message}', function ($message) {
    return view('verificationMessage', ['message' => $message]);
})->name('verify.message');

// Route::get('/{vue_capture?}', function () {
//     return view('app');
// })->where('vue_capture', '[\/\w\.-]*');

Route::get('/{url?}', function () {
    return view('app');
})->where('url', '\/|services|about-us|signin|signup|verify|profile');
