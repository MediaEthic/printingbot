<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('third_id');
            $table->foreign('third_id')
                ->references('id')
                ->on('thirds')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('address_line1')->nullable()->default(null);
            $table->string('address_line2')->nullable()->default(null);
            $table->string('address_line3')->nullable()->default(null);
            $table->string('postcode', 10)->nullable()->default(null);
            $table->string('city', 38)->nullable()->default(null);
            $table->unsignedInteger('country_id')->nullable()->default(75);
//            $table->foreign('country_id')
//                ->references('id')
//                ->on('countries')
//                ->onDelete('restrict')
//                ->onUpdate('restrict');
            $table->unsignedInteger('language_id')->nullable()->default(47);
//            $table->foreign('language_id')
//                ->references('id')
//                ->on('languages')
//                ->onDelete('restrict')
//                ->onUpdate('restrict');
            $table->unsignedInteger('time_zone_id')->nullable()->default(40);
//            $table->foreign('time_zone_id')
//                ->references('id')
//                ->on('time_zones')
//                ->onDelete('restrict')
//                ->onUpdate('restrict');
            $table->boolean('order')->nullable()->default(true);
            $table->boolean('delivery')->nullable()->default(true);
            $table->boolean('invoicing')->nullable()->default(true);
            $table->boolean('default')->nullable()->default(false);
            $table->boolean('active')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['third_id']);
        });
        Schema::dropIfExists('addresses');
    }
}
