<?php

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            'name' => 'Chèque',
        ]);

        DB::table('payments')->insert([
            'name' => 'Espèce',
        ]);

        DB::table('payments')->insert([
            'name' => 'Carte bancaire',
        ]);

        DB::table('payments')->insert([
            'name' => 'Prélèvement',
        ]);

        DB::table('payments')->insert([
            'name' => 'Virement',
        ]);
    }
}
