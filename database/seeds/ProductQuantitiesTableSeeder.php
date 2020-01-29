<?php

use Illuminate\Database\Seeder;

class ProductQuantitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ProductQuantity::class, 100)->create();
    }
}
