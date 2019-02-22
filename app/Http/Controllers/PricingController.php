<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Utility;

class PricingController extends Controller
{
    public function getMonthlyPrice ($utility, $provider, $product, $product_variation = null) {
        $price =  Utility::getProviderPriceList($utility, $provider,$product,$product_variation);

        return response()->json($price, $price['code']);
    }

    public function updateMonthlyPrice (Request $request, $utility, $provider, $product, $product_variation = null) {
        $request->validate([
            'price' => 'bail|required|numeric|regex:/^\d*(\.\d{1,2})?$/|',
        ]);
        $price =  Utility::updateProviderPriceList($request->price, $utility, $provider,$product,$product_variation);

        return response()->json($price, $price['code']);
    }
}
