<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablesFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->text('name')->nullable(true)->change();
            $table->text('href')->nullable(true)->change();
            $table->string('phone_number', 11)->nullable(true)->change();
            $table->string('address')->nullable(true)->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number',11)->nullable(true)->change();
            $table->string('address')->nullable(true)->change();
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->string('phone_number', 11)->nullable(true)->change();
            $table->string('address')->nullable(true)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->text('name')->nullable(false)->change();
            $table->text('href')->nullable(false)->change();
            $table->string('phone_number', 11)->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number',11)->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
        });
        Schema::table('bills', function (Blueprint $table) {
            $table->string('phone_number', 11)->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
        });

    }
}
