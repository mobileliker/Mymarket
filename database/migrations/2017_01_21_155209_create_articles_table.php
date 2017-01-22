<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('content');
            $table->integer('sort')->default(100);
            $table->timestamps();
        });

        Schema::table('articles', function($table) {
            $prefix = config('database.connections.mysql.prefix');
            $table->foreign('category_id', $prefix.'_articles_category_id_foreign')->references('id')->on('article_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
