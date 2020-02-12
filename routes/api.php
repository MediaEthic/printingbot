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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->prefix('auth')->namespace('Auth')->group(function() {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');


    Route::namespace('Settings')->prefix('/settings')->group(function () {
        Route::namespace('Company')->prefix('/company')->group(function () {
            Route::apiResource('/users', 'UserController');
        });

        Route::namespace('Accounting')->prefix('/accounting')->group(function () {
            Route::apiResource('/payments', 'PaymentController');
            Route::apiResource('/settlements', 'SettlementController');
            Route::apiResource('/vats', 'VatController');
        });

        Route::namespace('Third')->prefix('/third')->group(function () {
            Route::prefix('/customers')->group(function () {
                Route::post('/search', 'CustomerController@search');
            });
        });

        Route::namespace('Item')->prefix('/item')->group(function () {
            Route::prefix('/products')->group(function () {
                Route::get('/{pagination?}', 'ProductController@index');
                Route::post('/search', 'ProductController@search');
            });
        });
    });


    Route::namespace('Sales')->prefix('/sales')->group(function () {
        Route::apiResource('/invoices', 'InvoiceController');

        Route::prefix('/invoices')->group(function () {
            Route::post('/filtered', 'InvoiceController@filtered');
            Route::post('/status/edit', 'InvoiceController@editStatus');
            Route::get('/{invoice}/edit', 'InvoiceController@edit');
            Route::get('{invoices}/pdf', 'InvoiceController@generatePDF');
            Route::post('/customers/search', 'InvoiceController@searchCustomers');
            Route::delete('/{invoice}/lines/{id}', 'InvoiceLineController@destroy');
        });
//        Route::apiResource('/lines', 'InvoiceLineController');
    });
});
