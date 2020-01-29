<?php

use Illuminate\Database\Seeder;

class VatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vats')->insert([
            'name' => 'TVA à 20%',
            'rate' => '20',
            'collected' => '445710000',
            'deductible' => '445660000',
        ]);

        DB::table('vats')->insert([
            'name' => 'TVA à 10%',
            'rate' => '10',
            'collected' => '445721000',
            'deductible' => '445661000',
        ]);

        DB::table('vats')->insert([
            'name' => 'TVA à 5.5%',
            'rate' => '5.5',
            'collected' => '445720000',
            'deductible' => '445662000',
        ]);

        DB::table('vats')->insert([
            'name' => 'TVA à 0%',
            'rate' => '0',
            'collected' => '445730000',
            'deductible' => '445663000',
        ]);
    }
}
