<?php

namespace XCms\Events;
/*
* name HtmlCacheEvent.php
* user Yuanchang.xu
* date 2017/5/2
*/

use Illuminate\Support\Facades\Event;
use XCms\Article\Models\Article;

class HtmlCacheEvent extends Event
{

    /**
     * @var Article
     */
    public $article;

    public function __construct(Article $article)
    {

        $this->article = $article;
    }
}