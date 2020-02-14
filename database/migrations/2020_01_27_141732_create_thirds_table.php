<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thirds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableTimestamps();
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->enum('type', ['supplier', 'prospect', 'customer'])->default('customer');
            $table->string('name', 38);
            $table->string('alias', 10)->nullable()->default(null);
            $table->string('logo')->nullable()->default(null);
            $table->unsignedBigInteger('category_id')->nullable()->default(null);
            $table->enum('order_confirmation', ['Email', 'Post', 'Fax'])->default('Email');
            $table->unsignedBigInteger('bank_id')->nullable()->default(null);
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->foreign('parent_id')
                ->references('id')
                ->on('thirds')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->date('customer')->nullable()->default(null);

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
            $table->string('email')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);

            $table->string('ape', 5)->nullable()->default(null);
            $table->string('siret', 17)->nullable()->default(null);
            $table->string('intracommunity_no', 20)->nullable()->default(null);
            $table->unsignedBigInteger('territory_id')->nullable()->default(null);
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->double('commission_rate')->nullable()->default(null);
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
            $table->unsignedBigInteger('vat_id')->nullable()->default(1);
            $table->foreign('vat_id')
                ->references('id')
                ->on('vats')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->string('holder', 80)->nullable()->default(null);
            $table->string('bank', 80)->nullable()->default(null);
            $table->string('bank_code', 5)->nullable()->default(null);
            $table->string('sort_code', 5)->nullable()->default(null);
            $table->string('account', 11)->nullable()->default(null);
            $table->string('rib', 2)->nullable()->default(null);
            $table->string('iban', 35)->nullable()->default(null);
            $table->string('bic', 15)->nullable()->default(null);
            $table->string('subledger_account', 20)->nullable()->default(null);
            $table->unsignedInteger('concentration_account')->nullable()->default(null);
            $table->unsignedTinyInteger('invoice_number')->default('1');
            $table->unsignedTinyInteger('invoice_copy')->default('0');
            $table->boolean('monthend_invoices')->default(false);
            $table->boolean('grouping_invoices')->default(true);
            $table->boolean('statement')->default(false);
            $table->enum('credit_control', ['none', 'report', 'block', 'forbid'])->default('none');
            $table->unsignedInteger('credit_limit')->nullable()->default(null);
            $table->unsignedInteger('credit_insurance')->nullable()->default(null);
            $table->boolean('allow_order')->default(false);

            $table->text('head_order')->nullable()->default(null);
            $table->text('foot_order')->nullable()->default(null);
            $table->text('head_delivery')->nullable()->default(null);
            $table->text('foot_delivery')->nullable()->default(null);
            $table->text('head_invoice')->nullable()->default(null);
            $table->text('foot_invoice')->nullable()->default(null);
            $table->text('technical_remarks')->nullable()->default(null);
            $table->text('accounting_remarks')->nullable()->default(null);
            $table->unsignedBigInteger('mention_id')->nullable()->default(null);
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
        Schema::table('thirds', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropForeign(['parent_id']);
//            $table->dropForeign(['country_id']);
//            $table->dropForeign(['language_id']);
//            $table->dropForeign(['time_zone_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['payment_id']);
            $table->dropForeign(['settlement_id']);
            $table->dropForeign(['vat_id']);
        });

        Schema::dropIfExists('thirds');
    }
}
