<?php

/*
|--------------------------------------------------------------------------
| Article Web Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix'=>'admin','namespace'=>'XCms\Article\Controllers','middleware'=>['web','admin']],function(){
    /*
    |--------------------------------------------------------------------------
    | Article
    |--------------------------------------------------------------------------
    */

    Route::resource('articles','ArticleController');
    // video upload
    Route::post('article/upload/video','ArticleController@uploadVideo')->name('articles.upload.video');
    // video delete
    Route::post('article/delete/{id}/video','ArticleController@deleteVideo')->name('articles.delete.video');
    // thumb upload
    Route::post('article/upload/thumb','ArticleController@uploadThumb')->name('articles.upload.thumb');
    // thumb delete
    Route::post('article/delete/{id}/thumb','ArticleController@deleteThumb')->name('articles.delete.video');
    // get article body
    Route::get('article/{id}/body','ArticleController@getBody')->name('admin.articel.body');

    /*
    |--------------------------------------------------------------------------
    | Article Category
    |--------------------------------------------------------------------------
    */
    Route::resource('categories','CategoryController');
    Route::post('categories/{id}/sub','CategoryController@storeSub')->name('admin.article.category.child.store');
    Route::post('categories/all','CategoryController@all')->name('categories.all');

    /*
    |--------------------------------------------------------------------------
    | Article Module
    |--------------------------------------------------------------------------
    */
    Route::resource('modules','ModuleController');
});

Route::group(['prefix'=>'admin','namespace'=>'XCms\Block\Controllers','middleware'=>['web','admin']],function(){
    /*
    |--------------------------------------------------------------------------
    | Block
    |--------------------------------------------------------------------------
    */
    Route::resource('blocks','BlockController');
    // 上传图片
    Route::post('block/upload/image','BlockController@uploadImage')->name('admin.block.upload.image');
    // 删除block图片
    Route::post('block/delete/{id}/image','BlockController@deleteImage')->name('admin.block.delete.image.id');

    /*
     |--------------------------------------------------------------------------
     | Block分类路由
     |--------------------------------------------------------------------------
     */
    Route::resource('blockCategories','CategoryController');
});

Route::group(['prefix'=>'admin','namespace'=>'XCms\Setting\Controllers','middleware'=>['web','admin']],function(){
    /*
    |--------------------------------------------------------------------------
    | site
    |--------------------------------------------------------------------------
    */
    Route::resource('site','SiteController',['only'=>['index','store']]);
});

Route::group(['prefix'=>'admin','namespace'=>'XCms\Page\Controllers','middleware'=>['web','admin']],function(){
    /*
    |--------------------------------------------------------------------------
    | About Page
    |--------------------------------------------------------------------------
    */
    Route::resource('abouts','AboutController');
    // get about body
    Route::post('abouts/{id}/getBody','AboutController@getBody')->name('abouts.getBody');

    /*
    |--------------------------------------------------------------------------
    | Contact Page
    |--------------------------------------------------------------------------
    */
    Route::resource('contacts','ContactController');
    // get contact body   
    Route::post('contacts/{id}/getBody','ContactController@getBody')->name('contacts.getBody');

});

Route::group(['prefix'=>'admin','namespace'=>'XCms\Link','middleware'=>['web','admin']],function(){
    /*
    |--------------------------------------------------------------------------
    | Link
    |--------------------------------------------------------------------------
    */
    Route::resource('links','LinkController');
});

Route::group(['prefix'=>'admin','namespace'=>'XCms\Resource\Controllers','middleware'=>['web','admin']],function(){
    Route::resource('images','ImageController');
    Route::resource('videos','VideoController');
});
Route::group(['prefix'=>'admin','middleware' => ['web', 'admin'],'namespace'=>'XCms'],function(){
    Route::post('delete/image','BaseController@deleteImageResouce');
    Route::post('delete/video','BaseController@deleteVideoResouce');
});