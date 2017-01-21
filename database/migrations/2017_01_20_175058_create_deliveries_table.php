<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('delivery_type');
            $table->string('delivery_name')->nullable();
            $table->string('delivery_number')->nullable();
            $table->timestamps();
        });

        Schema::table('deliveries', function($table) {
            $prefix = config('database.connections.mysql.prefix');
            $table->foreign('order_id', $prefix.'_deliveries_order_id_foreign')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
