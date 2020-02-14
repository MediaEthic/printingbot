<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableTimestamps();
            $table->unsignedBigInteger('invoice_id')->nullable()->default(null);
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->enum('type', ['comment', 'product'])->default('product');
            $table->string('name')->nullable()->default(null);
            $table->text('description')->nullable()->default(null);
            $table->unsignedBigInteger('order_line_id')->nullable()->default(null);
            $table->unsignedBigInteger('delivery_line_id')->nullable()->default(null);
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('vat_id')->nullable()->default(1);
            $table->foreign('vat_id')
                ->references('id')
                ->on('vats')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('quantity')->nullable()->default(null);
            $table->double('unit_price')->nullable()->default(null);
            $table->double('subtotal')->nullable()->default(null);
            $table->double('discount_rate')->nullable()->default(null);
            $table->double('discount_amount')->nullable()->default(null);
            $table->double('total_pretax')->nullable()->default(null);
            $table->double('vat')->nullable()->default(null);
            $table->double('total')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['vat_id']);
        });

        Schema::dropIfExists('invoice_lines');
    }
}
