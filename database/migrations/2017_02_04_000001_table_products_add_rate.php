<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableProductsAddRate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('count_rate')->default(10);
            $table->integer('delivery_rate')->default(10);
            $table->integer('sever_rate')->default(10);
            $table->integer('product_rate')->default(10);
        });
    }
}
