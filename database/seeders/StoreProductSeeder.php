<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $store = Store::find(1);
        $data = [
            ['product_id' => 1, 'count' => 10],
            ['product_id' => 2, 'count' => 5],
            ['product_id' => 3, 'count' => 2]
        ];
        $store->products()->attach($data);

        $store = Store::find(2);
        $data = [
            ['product_id' => 1, 'count' => 1],
            ['product_id' => 2, 'count' => 2],
            ['product_id' => 3, 'count' => 20]
        ];
        $store->products()->attach($data);

        $store = Store::find(3);
        $data = [
            ['product_id' => 2, 'count' => 4],
            ['product_id' => 4, 'count' => 5],
            ['product_id' => 5, 'count' => 10]
        ];
        $store->products()->attach($data);
    }
}
