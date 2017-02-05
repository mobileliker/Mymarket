<?php

/**
 * Antvel - Data Base
 * Orders Detail Table.
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TableOrderDetailsAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->integer('delivery_rate')->default(10);
            $table->integer('sever_rate')->default(10);
            $table->text('image')->nullable();
            $table->string('reply')->nullable();
        });
    }
}


