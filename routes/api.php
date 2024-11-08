<?php

use Illuminate\Http\Request;

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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
// mobile apis


Route::group(['middleware' => 'setLocalSession'], function() {
        
    Route::post('/user/check-user-exist',              "Auth\LoginController@checkUserExist");
    Route::post('/user/logout',                        "Auth\LoginController@userLogout");

    Route::post('/user/register-user',                 "Auth\LoginController@userRegistration");
    Route::post('/user/add-user',                      "API\CustomerController@store");
    Route::post('/user/get-user/{id}',                 "API\CustomerController@show");
    Route::post('user/depositbalance',                 "API\CustomerController@bankTransfer");
    Route::post('user/get-orders',                     "API\CustomerController@getOrderbyCustomer");
    Route::post('orders/get-order',                    "API\CustomerController@getJsonOrder");
    Route::post('department/getcategoriesbydept',      "API\DepartmentController@getCategoriesbyDepartment");
    Route::post('category/getsubcategories',           "API\CategoryController@getSubCategories");
    Route::post('category/getservices',                "API\CategoryController@getServices");
    Route::post('wallet/getwalletbalance',             "API\CustomerController@getWalletBalance");
    Route::post('user/place-order',                    "API\CustomerController@placeOrder");
    Route::patch('user/update-order',                  "API\CustomerController@updateOrder");
    Route::get('get/place-order-detail',               "API\CustomerController@getPlaceOrderDetail");
    Route::post('order/requirement/savedata',          "API\CustomerController@saveRequirementData");

    Route::get('department/get-groups',                "API\DepartmentController@getGroups");
    Route::get('department/getdepartments',            "API\DepartmentController@getDepartments");
    Route::get('user/wallet-history/{customer_id}',    "API\CustomerController@walletHistory");
    Route::get('user/order/cancel-order/{order_id}',   "API\CustomerController@cancelOrder");

    Route::put('/admin/update-profile/{id}',           "API\CustomerController@updateAdminUser");

    Route::get('department/getdepartmentsbygroup/{group_id}', "API\DepartmentController@getDepartmentsByGroup");
    Route::get('service/getdetail/{service_id}/{user_id}',    "API\CategoryController@getServiceDetail");
    // Admin
    Route::group(['prefix' => 'admin'], function () {
        Route::get('get-statistics/{id}',               "API\AdminController@getStatistics");
        Route::get('get-bank-details/{id}',             "API\AdminController@getBankDetails");
        Route::get('get-services',                      "API\AdminController@getServices");
        Route::get('get-customers',                     "API\AdminController@getCustomers");
        Route::get('get-transactions',                  "API\AdminController@getTransactions");
        Route::get('get-deposit-transactions',          "API\AdminController@getDepositTransactions");
        Route::get('getTransactionsByCustomer/{id}',    "API\AdminController@getTransactionsByCustomer");
        Route::put('update-transaction/{id}',           "API\AdminController@updateTransactionStatus");
        Route::post('update-order/{id}',                 "API\AdminController@updateOrder");
        Route::post('order/send-message',               "API\AdminController@sendMessage");
        Route::post('order/fetch-messages',             "API\AdminController@fetchMessages");
        Route::post('request-change-number',            "API\AdminController@requestChangeNumber");
        Route::get('getCustomerBalance/{id}',    "API\AdminController@getCustomerBalance");
    });

    Route::post('customer/email-verify-send/{id}',      "API\CustomerController@verifyEmailSend");
    Route::get('email/verify/{user_type}/{token}',      "API\CustomerController@verifyCustomerEmail");
    Route::get('order/fetch-messages/{id}',             "API\CustomerController@fetchMessages");
    Route::post('order/send-message',                   "API\CustomerController@sendMessage");
    Route::get('getalldocuments',                       "API\AdminController@getDocumentsForMobile");
    Route::DELETE('document/delete/{customer_document_id}',"API\AdminController@deleteCustomerDocument");
    Route::get('getDocumentDetailOnly/{doc_type}/{user_id}', "API\AdminController@getDocumentDetailOnly");
    Route::get('documentDetail/{document}',             "API\AdminController@getCustomerDocumentById");
    Route::get('documentDetailWithSchema/{id}',         "API\AdminController@getCustomerDocumentWithSchemaById");
    Route::post('savedocumentdata',                     "API\CustomerController@saveDocumentData");
    Route::get('getdocuments/{customer}/{cust_doc_id?}',  "API\AdminController@getDocumentByCustId");
    Route::get('getdocuments/{document}/{customer}/{cust_doc_id?}',  "API\AdminController@getDocumentByDocId");

    // vue website
    Route::post('customer/login',                       "Auth\LoginController@customerLogin");
    Route::post('customer/registration',                "Auth\LoginController@customerRegister");
    Route::post('customer/verify',                      "Auth\LoginController@customerVerify");

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('customer/update-profile',              "Auth\LoginController@updateCustomer");
        Route::post('customer/placeorder',                  "API\CustomerController@placeOrder");
        Route::post('requirement/savedata',                 "API\CustomerController@saveRequirementData");
        Route::post('document/savedata',                    "API\CustomerController@saveDocumentData");
        Route::post('customer/bank-transfer',               "API\CustomerController@bankTransfer");
        Route::post('wallet/get-wallet-balance',            "API\CustomerController@getWalletBalance");
        Route::post('department/get-categories',            "API\DepartmentController@getCategoriesbyDepartment");
        Route::post('category/get-subcategories',           "API\CategoryController@getSubCategoriesWithServices");
        Route::post('category/get-subcats',                 "API\CategoryController@getSubCategories");
        Route::post('customer/get-orders',                  "API\CustomerController@getOrderbyCustomer");
        Route::post('customer/logout',                      "Auth\LoginController@customerLogin");

        Route::get('documents/get-all',                     "API\AdminController@getDocuments");
        Route::get('customer/document-detail/{document}',   "API\AdminController@getCustDocumentById");
        Route::get('/documents/get/{document}/{customer}/{cust_doc_id?}',  "API\AdminController@getDocumentByDocId");
        Route::get('department/get-departments',            "API\DepartmentController@getDepartments");
        Route::get('order/cancel-order/{order_id}',         "API\CustomerController@cancelOrder");
        Route::get('service/get-service/{service_id}/{user_id}', "API\CategoryController@getServiceDetail");


        // Routes with protections
        Route::put('user/update-user',               "API\CustomerController@update");
        Route::post('/user/get-notifications',       "API\AdminController@getNotifications");
        Route::post('user/fundtransfer',             "API\CustomerController@balanceShare");
    });

});
