<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->nullableTimestamps();
            $table->string('name', 38);
            $table->string('logo', 200)->nullable()->default(null);
            $table->string('legal_form', 45)->nullable()->default(null);
            $table->string('capital', 45)->nullable()->default(null);
            $table->string('register', 45)->nullable()->default(null);
            $table->string('siret', 45)->nullable()->default(null);
            $table->string('tva', 45)->nullable()->default(null);
            $table->string('ape', 200)->nullable()->default(null);
            $table->date('expiry_date')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
