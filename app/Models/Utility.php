<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    private $utility_model;

    private $provider_model;

    private $product_model;

    private $variation_model = null;

    public function providers () {
        return $this->hasMany('App\Models\Provider');
    }

    public static function getProviderPriceList($utility, $provider, $product, $product_variation = null) {

        $error = null;

        if(!$utility_model = self::where('slug', $utility)->first()) {
            $error = "Utility not found";
        }
        elseif(!$provider = $utility_model->providers()->where('slug', $provider)->first()) {
            $error = "Provider not found";
        }
        elseif(!$product = $provider->products()->where('slug', $product)->first()) {
            $error = "Product not found";
        }
        elseif($product_variation) {
            if(!$variation = $product->product_variations()->where('slug', $product_variation)->first()){
                $error = "Product variation not found";
            }
        }
        elseif(!$product->price && !isset($variation)) {
            $error = "Product variation is required for requested product";
            $code = 422;
        }

        if($error) {
            return [
                'success' => false,
                'message' => $error,
                'code' => (isset($code) ? $code : 401 ),
            ];
        }

        return [
            'success' => true,
            'code' => 200,
            'data' => [
                'price' => $product->price ? $product->price : $variation->price,
                'unit' => 'usd',
                'utility' => $utility_model->name,
                'provider' => $provider->name,
                'product' => $product->name,
                'product_variation' => (isset($variation) ? $variation->name : null),
            ]
        ];

    }

    public static function updateProviderPriceList($price, $utility, $provider, $product, $product_variation = null) {

        $error = null;

        if(!$utility_model = self::where('slug', $utility)->first()) {
            $error = "Utility not found";
        }
        elseif(!$provider = $utility_model->providers()->where('slug', $provider)->first()) {
            $error = "Provider not found";
        }
        elseif(!$product = $provider->products()->where('slug', $product)->first()) {
            $error = "Product not found";
        }
        elseif($product_variation) {
            if(!$variation = $product->product_variations()->where('slug', $product_variation)->first()){
                $error = "Product variation not found";
            }
        }
        elseif(!$product->price && !isset($variation)) {
            $error = "Product variation is required for requested product";
            $code = 422;
        }

        if($error) {
            return [
                'success' => false,
                'message' => $error,
                'code' => (isset($code) ? $code : 401 ),
            ];
        }

       $update_model = isset($variation) ? $variation : $product;

        $update_model->price = $price;

        if(! $update_model->save()) {
            return [
                'success' => false,
                'message' => 'Price Update failed, please try again',
                'code' => 500
            ];
        }

        return [
            'success' => true,
            'code' => 201,
            'message' => 'Resource Updated',
            'data' => [
                'price' => $update_model->price,
                'unit' => 'usd',
                'utility' => $utility_model->name,
                'provider' => $provider->name,
                'product' => $product->name,
                'product_variation' => (isset($variation) ? $variation->name : null),
            ]
        ];

    }

}
