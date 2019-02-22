<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Utility;

class TestApiRoutesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEnergyPriceGet()
    {
        $this->seed('InitialTableSeeder');

        $utility = Utility::where('slug', 'energy')->first();

        $provider = $utility->providers()->inRandomOrder()->first();

        $product = $provider->products()->inRandomOrder()->first();

        $product_variation = $product->product_variations()->inRandomOrder()->first();


        $response = $this->json('get', "/api/energy/price/monthly/{$provider->slug}/{$product->slug}/{$product_variation->slug}");

        $response->assertStatus(200)
            ->assertJson([
            'success' => true,
             'data' => [
                 'price' => $product_variation->price,
                 'provider' => $provider->name
             ]
        ]);
    }

    public function testEnergyPriceGetWithoutProductVariation()
    {
        $this->seed('InitialTableSeeder');

        $utility = Utility::where('slug', 'energy')->first();

        $provider = $utility->providers()->inRandomOrder()->first();

        $product = $provider->products()->inRandomOrder()->first();

        $product_variation = $product->product_variations()->inRandomOrder()->first();


        $response = $this->json('get', "/api/energy/price/monthly/{$provider->slug}/{$product->slug}");

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testEnergyPriceGetWithInvalidParameter()
    {
        $this->seed('InitialTableSeeder');

        $utility = Utility::where('slug', 'energy')->first();

        $provider = $utility->providers()->inRandomOrder()->first();

        $product = $provider->products()->inRandomOrder()->first();

        $product_variation = $product->product_variations()->inRandomOrder()->first();


        $response = $this->json('get', "/api/energy/price/monthly/yyy/{$product->slug}");

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function testBroadbandPriceGet()
    {
        $this->seed('InitialTableSeeder');

        $utility = Utility::where('slug', 'broadband')->first();

        $provider = $utility->providers()->inRandomOrder()->first();

        $product = $provider->products()->inRandomOrder()->first();

        $response = $this->json('get', "/api/broadband/price/monthly/{$provider->slug}/{$product->slug}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'price' => $product->price,
                    'provider' => $provider->name
                ]
            ]);
    }

    public function testEnergyPricesPatch()
    {
        $this->seed('InitialTableSeeder');

        $utility = Utility::where('slug', 'energy')->first();

        $provider = $utility->providers()->inRandomOrder()->first();

        $product = $provider->products()->inRandomOrder()->first();

        $product_variation = $product->product_variations()->inRandomOrder()->first();

        $price_to_change = rand(1, 100);

        $response = $this->json('PATCH', "/api/energy/price/monthly/{$provider->slug}/{$product->slug}/{$product_variation->slug}",
            ['price' => $price_to_change]);


        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'provider' => $provider->name
                ]
            ]);
    }

    public function testEnergyPricesPatchDatabase()
    {
        $this->seed('InitialTableSeeder');

        $utility = Utility::where('slug', 'energy')->first();

        $provider = $utility->providers()->inRandomOrder()->first();

        $product = $provider->products()->inRandomOrder()->first();

        $product_variation = $product->product_variations()->inRandomOrder()->first();

        $price_to_change = rand(1, 100);

        $response = $this->json('PATCH', "/api/energy/price/monthly/{$provider->slug}/{$product->slug}/{$product_variation->slug}",
            ['price' => $price_to_change]);


        $this->assertDatabaseHas('product_variations', [
            'product_id' => $product_variation->product_id,
            'price' => $price_to_change,
        ]);
    }

    public function testEnergyPricesPatchInvalidDataRequest()
    {
        $this->seed('InitialTableSeeder');

        $utility = Utility::where('slug', 'energy')->first();

        $provider = $utility->providers()->inRandomOrder()->first();

        $product = $provider->products()->inRandomOrder()->first();

        $product_variation = $product->product_variations()->inRandomOrder()->first();

        $response = $this->json('PATCH', "/api/energy/price/monthly/{$provider->slug}/{$product->slug}/{$product_variation->slug}",
            ['price' => 'asdf']);


        $response->assertStatus(422);
    }

    public function testEnergyPricesPatchInvalidMoneyRequest()
    {
        $this->seed('InitialTableSeeder');

        $utility = Utility::where('slug', 'energy')->first();

        $provider = $utility->providers()->inRandomOrder()->first();

        $product = $provider->products()->inRandomOrder()->first();

        $product_variation = $product->product_variations()->inRandomOrder()->first();

        $response = $this->json('PATCH', "/api/energy/price/monthly/{$provider->slug}/{$product->slug}/{$product_variation->slug}",
            ['price' => '303.313']);


        $response->assertStatus(422);
    }
}
