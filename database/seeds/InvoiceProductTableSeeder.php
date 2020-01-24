<?php

use Illuminate\Database\Seeder;

class InvoiceProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\InvoiceProduct::class, 200)->create();
    }
}
