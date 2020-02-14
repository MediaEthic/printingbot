<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableTimestamps();
            $table->enum('title', ['Mr.', 'Ms.'])->nullable()->default('Mr.');
            $table->string('alias', 10)->nullable()->default(null);
            $table->string('name', 38)->nullable()->default(null);
            $table->string('lastname', 38)->nullable()->default(null);
            $table->unsignedBigInteger('establishment_id')->nullable()->default(null);
            $table->foreign('establishment_id')
                ->references('id')
                ->on('establishments')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
            $table->string('mobile', 20)->nullable()->default(null);
            $table->string('phone', 20)->nullable()->default(null);
            $table->boolean('accounting')->default(false);
            $table->boolean('trade')->default(false);
            $table->boolean('quotation')->default(false);
            $table->boolean('operator')->default(true);
            $table->boolean('supervisor')->default(false);
            $table->boolean('manager')->default(false);
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
        });

        Schema::dropIfExists('users');
    }
}
