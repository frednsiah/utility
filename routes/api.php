<?php

use Illuminate\Http\Request;
use App\Models\Utility;

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

Route::get('/{utility}/price/monthly/{provider}/{product}/{product_variation?}', 'PricingController@getMonthlyPrice');

Route::patch('/{utility}/price/monthly/{provider}/{product}/{product_variation?}', 'PricingController@updateMonthlyPrice');

