<?php

use Illuminate\Database\Seeder;
use App\ArticleCategory, App\Article;

class ArticleCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articleCategory = ArticleCategory::firstOrCreate(['name' => 'pattern-of-payment', 'display_name' => '支付方式']);
        $article = Article::firstOrCreate(['title' => '快捷支付', 'slug' => 'quick-payment', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '支 付 宝', 'slug' => 'alipay', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '信 用 卡', 'slug' => 'credit-card', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '货到付款', 'slug' => 'cash-on-delivery', 'category_id' => $articleCategory->id]);

        $articleCategory = ArticleCategory::firstOrCreate(['name' => 'merchant-services', 'display_name' => '商家服务']);
        $article = Article::firstOrCreate(['title' => '我要供货', 'slug' => 'supply', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '物流服务', 'slug' => 'logistics-service', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '供货规则', 'slug' => 'supply-rules', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '运营服务', 'slug' => 'operation-service', 'category_id' => $articleCategory->id]);

        $articleCategory = ArticleCategory::firstOrCreate(['name' => 'concact-us', 'display_name' => '联系我们']);
        $article = Article::firstOrCreate(['title' => '服务电话', 'slug' => 'phone-number', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '微博', 'slug' => 'weibo', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '微信公众号', 'slug' => 'wechat', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '邮箱', 'slug' => 'email', 'category_id' => $articleCategory->id]);

        $articleCategory = ArticleCategory::firstOrCreate(['name' => 'help-us', 'display_name' => '帮助中心']);
        $article = Article::firstOrCreate(['title' => '缺货赔付', 'slug' => 'shortage-of-compensation', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '发票保障', 'slug' => 'invoice-to-ensure', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '售后规则', 'slug' => 'after-sales-rules', 'category_id' => $articleCategory->id]);
        $article = Article::firstOrCreate(['title' => '购物指南', 'slug' => 'shopping-guide', 'category_id' => $articleCategory->id]);

        $article = Article::firstOrCreate(['title' => '关于我们', 'slug' => 'about-us']);
        $article = Article::firstOrCreate(['title' => '法律声明', 'slug' => 'legal-notice']);
        $article = Article::firstOrCreate(['title' => '使用协议', 'slug' => 'protocol-of-usage']);
        $article = Article::firstOrCreate(['title' => '版权隐私', 'slug' => 'privacy-policy']);
        $article = Article::firstOrCreate(['title' => '友情链接', 'slug' => 'friendly-link']);
        $article = Article::firstOrCreate(['title' => '成功案列', 'slug' => 'successful-case']);
        $article = Article::firstOrCreate(['title' => '菜市大事记', 'slug' => 'memorabilia']);
        $article = Article::firstOrCreate(['title' => '产品库', 'slug' => 'production-library']);
        $article = Article::firstOrCreate(['title' => '网站地图', 'slug' => 'website-map']);

    }
}
