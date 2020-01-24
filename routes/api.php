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

Route::prefix('/auth')->group(function () {
    Route::namespace('Sales')->prefix('/sales')->group(function () {
        Route::prefix('/invoices')->group(function () {
            Route::post('/', 'InvoiceController@index');
            Route::get('{invoices}/pdf', 'InvoiceController@generatePDF');
            Route::post('/customers/search', 'InvoiceController@searchCustomers');
        });
    });
});
