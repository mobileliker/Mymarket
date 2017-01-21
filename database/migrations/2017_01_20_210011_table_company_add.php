<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCompanyAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function (Blueprint $table) {

            /**支付模块*/
            $table->text('shortcut')->nullable();//快捷支付
            $table->text('alipay')->nullable();//支付宝
            $table->text('credit')->nullable();//信用卡
            $table->text('delivery_pay')->nullable();//货到付款

            /**商家模块*/
            $table->text('supply_me')->nullable();//我要供货
            $table->text('delivery_serve')->nullable();//物流服务
            $table->text('supply_rule')->nullable();//供货规则
            $table->text('operation_serve')->nullable();//运营服务

            /**联系模块*/
            $table->text('microblog')->nullable();//微博
            $table->text('public')->nullable();//公众号

            /**帮助模块*/
            $table->text('compensate_oos')->nullable();// 缺货赔付
            $table->text('bill')->nullable();//发票保障
            $table->text('shopping_guide')->nullable();//购物指南
            $table->text('after_sale')->nullable();//售后规则   
 
            /**其它模块*/
            $table->text('friend')->nullable();//友情链接
            $table->text('thing_max')->nullable();//菜市大事记
            $table->text('product')->nullable();//产品库
            $table->text('map')->nullable();//网站地图  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function (Blueprint $table) {
            //
        });
    }
}
