<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name' => 'Ethic',
            'logo' => 'logo-ethic-software.png',
            'legal_form' => 'SAS',
            'capital' => '40000€',
            'register' => 'Bayonne B 429 542 764',
            'siret' => '429 542 764 00031',
            'tva' => 'FR85 429542764',
            'ape' => '6202A Conseil en systèmes et logiciels informatiques',
            'expiry_date' => '2020-12-31',
        ]);
    }
}
