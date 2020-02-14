<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableTimestamps();
            $table->unsignedTinyInteger('company_id')->nullable()->default('1');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('name', 38);
            $table->string('logo', 200)->nullable()->default(null);
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
            $table->string('phone', 35)->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->text('head_quotation')->nullable()->default(null);
            $table->text('foot_quotation')->nullable()->default(null);
            $table->text('head_delivery')->nullable()->default(null);
            $table->text('foot_delivery')->nullable()->default(null);
            $table->text('head_invoice')->nullable()->default(null);
            $table->text('foot_invoice')->nullable()->default(null);
            $table->enum('invoice_prefix1', ['YYYY', 'YY', 'MM'])->default('YY');
            $table->enum('invoice_prefix2', ['YYYY', 'YY', 'MM'])->default('MM');
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
//            $table->dropForeign(['country_id']);
//            $table->dropForeign(['language_id']);
//            $table->dropForeign(['time_zone_id']);
        });

        Schema::dropIfExists('establishments');
    }
}
