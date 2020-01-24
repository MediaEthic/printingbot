<?php

use App\Models\InvoiceProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
         $this->call(InvoiceTableSeeder::class);
         $this->call(InvoiceProductTableSeeder::class);
    }
}
