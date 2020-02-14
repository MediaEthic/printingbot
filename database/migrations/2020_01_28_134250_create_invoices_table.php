<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableTimestamps();
            $table->unsignedBigInteger('establishment_id')->nullable()->default(null);
            $table->foreign('establishment_id')
                ->references('id')
                ->on('establishments')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('invoice_no')->nullable()->default(null);
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('name')->nullable()->default(null);
            $table->date('invoice_date')->nullable()->default(null);
            $table->date('due_date')->nullable()->default(null);
            $table->enum('invoice_status', ['draft', 'edited', 'payed'])->default('draft');
            $table->unsignedBigInteger('third_id')->nullable()->default(null);
            $table->foreign('third_id')
                ->references('id')
                ->on('thirds')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('third_alias', 10)->nullable()->default(null);
            $table->string('third_name', 38)->nullable()->default(null);
            $table->string('third_address_line1')->nullable()->default(null);
            $table->string('third_address_line2')->nullable()->default(null);
            $table->string('third_address_line3')->nullable()->default(null);
            $table->string('third_postcode', 10)->nullable()->default(null);
            $table->string('third_city', 38)->nullable()->default(null);
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
            $table->string('third_intracommunity_no', 20)->nullable()->default(null);
            $table->string('third_reference')->nullable()->default(null);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->double('user_commission_base')->nullable()->default(null);
            $table->double('user_commission_rate')->nullable()->default(null);
            $table->double('user_commission_amount')->nullable()->default(null);
            $table->double('discount_rate')->nullable()->default(null);
            $table->double('bank_rate')->nullable()->default(null);
            $table->unsignedInteger('discount_duration')->nullable()->default(null);
            $table->unsignedBigInteger('payment_id')->nullable()->default(1);
            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('settlement_id')->nullable()->default(1);
            $table->foreign('settlement_id')
                ->references('id')
                ->on('settlements')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->double('subtotal')->nullable()->default(null);
            $table->double('discount_amount')->nullable()->default(null);
            $table->double('total_pretax')->nullable()->default(null);
            $table->double('vat')->nullable()->default(null);
            $table->double('total')->nullable()->default(null);
            $table->unsignedBigInteger('sales_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['third_id']);
//            $table->dropForeign(['country_id']);
//            $table->dropForeign(['language_id']);
//            $table->dropForeign(['time_zone_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['payment_id']);
            $table->dropForeign(['settlement_id']);
        });

        Schema::dropIfExists('invoices');
    }
}
