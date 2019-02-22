<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $energy_id = DB::table('utilities')->insertGetId([
            'name' => 'Energy',
            'slug' => 'energy',
        ]);

        $broadband_id = DB::table('utilities')->insertGetId([
            'name' => 'Broadband',
            'slug' => 'broadband',
        ]);


            $bsnl_id = DB::table('providers')->insertGetId([
                'name' => 'BSNL',
                'slug' => 'bsnl',
                'utility_id' => $broadband_id
            ]);

        $bsnl_broadband_products = [
            [
                'name' => '100MB',
                'slug' => '100mb',
                'price' => '30',
                'provider_id' => $bsnl_id
            ],
            [
                'name' => '200MB',
                'slug' => '200mb',
                'price' => '40',
                'provider_id' => $bsnl_id
            ],
            [
                'name' => '300MB',
                'slug' => '300mb',
                'price' => '50',
                'provider_id' => $bsnl_id
            ],
        ];

        DB::table('products')->insert($bsnl_broadband_products);

        $airtel_id = DB::table('providers')->insertGetId([
                'name' => 'Airtel',
                'slug' => 'airtel',
                'utility_id' => $broadband_id
            ]);

        $airtel_broadband_products = [
            [
                'name' => '17MB',
                'slug' => '17mb',
                'price' => '25',
                'provider_id' => $airtel_id
            ],
            [
                'name' => '72MB',
                'slug' => '72mb',
                'price' => '40',
                'provider_id' => $airtel_id
            ],
        ];

        DB::table('products')->insert($airtel_broadband_products);




        $indane_id = DB::table('providers')->insertGetId(
            [
                'name' => 'Indane energy',
                'slug' => 'indane',
                'utility_id' => $energy_id
            ]);
        $tata_id = DB::table('providers')->insertGetId(
            [
                'name' => 'Tata Power',
                'slug' => 'tata',
                'utility_id' => $energy_id
            ]);


        $indane_energy_products = [
            [
                'name' => 'Standard tariff',
                'slug' => 'standard',
                'provider_id' => $indane_id,
                'variations' => [
                    [
                        'name' => 'North',
                        'slug' => 'north',
                        'price' => '54.12',
                    ],
                    [
                        'name' => 'Mid',
                        'slug' => 'mid',
                        'price' => '56.50',
                    ],
                    [
                        'name' => 'South',
                        'slug' => 'south',
                        'price' => '61.92',
                    ]
                ]
            ],
            [
                'name' => 'Green tariff',
                'slug' => 'green',
                'provider_id' => $indane_id,
                'variations' => [
                    [
                        'name' => 'North',
                        'slug' => 'north',
                        'price' => '64.85',
                    ],
                    [
                        'name' => 'Mid',
                        'slug' => 'mid',
                        'price' => '68.21',
                    ],
                    [
                        'name' => 'South',
                        'slug' => 'south',
                        'price' => '71.66',
                    ]
                ]
            ],
        ];

        foreach($indane_energy_products as $indane_energy_product) {
            $variations = null;

            $variations = $indane_energy_product['variations'];
            unset($indane_energy_product['variations']);

            $indane_energy_product_id = DB::table('products')->insertGetId($indane_energy_product);
            foreach($variations as $variation) {
                $variation['product_id'] = $indane_energy_product_id;
                DB::table('product_variations')->insert($variation);
            }
        }

        $tata_energy_products = [
            [
                'name' => 'Standard tariff',
                'slug' => 'standard',
                'provider_id' => $tata_id,
                'variations' => [
                    [
                        'name' => 'North',
                        'slug' => 'north',
                        'price' => '51.95',
                    ],
                    [
                        'name' => 'Mid',
                        'slug' => 'mid',
                        'price' => '52.00',
                    ],
                    [
                        'name' => 'South',
                        'slug' => 'south',
                        'price' => '56.62',
                    ]
                ]
            ],
            [
                'name' => 'Saver tariff',
                'slug' => 'saver',
                'provider_id' => $tata_id,
                'variations' => [
                    [
                        'name' => 'North',
                        'slug' => 'north',
                        'price' => '42.57',
                    ],
                    [
                        'name' => 'Mid',
                        'slug' => 'mid',
                        'price' => '45.22',
                    ],
                    [
                        'name' => 'South',
                        'slug' => 'south',
                        'price' => '47.67',
                    ]
                ]
            ],
        ];

        foreach($tata_energy_products as $tata_energy_product) {
            $variations = null;

            $variations = $tata_energy_product['variations'];
            unset($tata_energy_product['variations']);

            $tata_energy_product_id = DB::table('products')->insertGetId($tata_energy_product);
            foreach($variations as $variation) {
                $variation['product_id'] = $tata_energy_product_id;
                DB::table('product_variations')->insert($variation);
            }
        }

    }
}
