<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('third_id');
            $table->foreign('third_id')
                ->references('id')
                ->on('thirds')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->enum('title', ['Mr.', 'Ms.'])->nullable()->default('Mr.');
            $table->string('name', 38)->nullable()->default(null);
            $table->string('lastname', 38)->nullable()->default(null);
            $table->string('profession', 80)->nullable()->default(null);
            $table->string('service', 38)->nullable()->default(null);
            $table->string('email', 100)->nullable()->default(null);
            $table->string('mobile', 50)->nullable()->default(null);
            $table->string('phone', 50)->nullable()->default(null);
            $table->boolean('default')->default(false);
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
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['third_id']);
        });
        Schema::dropIfExists('contacts');
    }
}
