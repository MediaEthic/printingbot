<?php

use Illuminate\Database\Seeder;

class InvoiceLinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\InvoiceLine::class, 150)->create();
    }
}
