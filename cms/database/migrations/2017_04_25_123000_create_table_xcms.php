<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableXCms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks_categories', function ($table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('slug', 200)->nullable();
            $table->string('title', 200)->nullable();
            $table->text('details')->nullable();
            $table->enum('status', ['show', 'hide'])->default('hide')->nullable();
            $table->timestamps();
            $table->engine = 'INNODB';
        });

        Schema::create('blocks', function ($table) {
            $table->increments('id');
            $table->integer('category_id')->nullable()->index();
            $table->string('name', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->integer('order')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('images')->nullable();
            $table->string('slug', 200)->nullable();
            $table->enum('status', ['show', 'hide'])->default('hide')->nullable();
            $table->timestamps();
            $table->engine = 'INNODB';
        });

        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->comment('模型名称');
            $table->string('slug',50)->nullable()->comment('模型标识')->index();
            $table->timestamps();
        });

        Schema::create('article_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable()->comment('上级id')->index();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable()->comment('树的层级');
            $table->string('name')->comment('分类名称');
            $table->unsignedInteger('order')->default(1)->comment('排序');
            $table->boolean('status')->default(1)->comment('1-状态 0-隐藏 1-显示');
            $table->foreign('parent_id')->references('id')->on('article_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'INNODB';
        });

        Schema::create('articles', function (Blueprint $table) {
            // 基本信息
            $table->increments('id');
            $table->unsignedInteger('category_id')->nullable()->comment('文章分类id')->index();
            $table->unsignedInteger('module_id')->nullable()->comment('文章模型id')->index();
            $table->string('name',50)->comment('名称');
            $table->string('title')->comment('标题');
            $table->unsignedInteger('order')->default(1)->comment('权重,越小越靠前');
            $table->string('tag')->nullable()->comment('TAG标签');
            $table->string('thumb')->nullable()->comment('缩略图');
            $table->longText('body')->comment('内容');
            $table->string('video')->nullable()->comment('视频');
            $table->boolean('is_watermark')->default(0)->comment('0-添加水印 0-不添加 1-添加');
            // 高级参数
            $table->boolean('is_comment')->default(0)->comment('0-是否评论 0-允许评论 1-禁止评论');
            $table->unsignedInteger('browse_count')->nullable()->default(0)->comment('浏览次数');
            $table->string('author')->nullable()->comment('作者');
            $table->string('abstract')->nullable()->comment('摘要');
            $table->string('keyword')->nullable()->comment('关键字');
            $table->timestamps();
            $table->engine = 'INNODB';
        });
        Schema::create('links',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->comment('名称');
            $table->string('url')->comment('链接');
            $table->smallInteger('order')->default(1)->comment('排序');
            $table->string('description')->nullable()->comment('简介');
            $table->timestamps();
        });

        Schema::create('abouts',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->comment('名称');
            $table->string('slug')->unique()->comment('标识');
            $table->longText('body')->nullable()->comment('内容');
            $table->timestamps();
        });

        Schema::create('contacts',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->nullable()->comment('名称');
            $table->string('slug')->unique()->comment('标识');
            $table->string('mobile',11)->comment('手机');
            $table->string('email',50)->comment('邮箱');
            $table->string('tel',20)->comment('电话');
            $table->string('wx',15)->nullable()->comment('微信');
            $table->string('qq',15)->nullable()->comment('qq');
            $table->longText('body')->nullable()->comment('内容');
            $table->timestamps();
        });

        Schema::create('contacts',function (Blueprint $table) {
            $table->tinyInteger('id',1)->comment('id');
            $table->string('icp')->comment('icp备案号');
            $table->string('copyright')->comment('版权信息');
            $table->boolean('status')->comment('状态-1 0-关闭 1-正常');
            $table->string('close_cause')->comment('关闭原因');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks_categories');
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('article_categories');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('links');
        Schema::dropIfExists('abouts');
        Schema::dropIfExists('contacts');
    }
}
