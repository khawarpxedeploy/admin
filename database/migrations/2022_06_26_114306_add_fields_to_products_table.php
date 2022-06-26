<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('fonts_enabled')->default(0);
            $table->boolean('symbols_enabled')->default(0);
            $table->string('questions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('fonts_enabled')->default(0);
            $table->boolean('symbols_enabled')->default(0);
            $table->string('questions')->nullable();
        });
    }
}
