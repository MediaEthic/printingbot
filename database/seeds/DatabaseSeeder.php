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
        $this->call(CountriesTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(TimeZonesTableSeeder::class);
        $this->call(CompaniesTableSeeder::class);
        $this->call(EstablishmentsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(SettlementsTableSeeder::class);
        $this->call(VatsTableSeeder::class);
        $this->call(ThirdsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductQuantitiesTableSeeder::class);
        $this->call(InvoiceTableSeeder::class);
    }
}
