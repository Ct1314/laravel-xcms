<?php

namespace XCms;

class XCms
{
    public function block()
    {
        return new \XCms\DataStores\Block;
    }

    public function art()
    {
        return new \XCms\DataStores\Article;
    }

    public function artCat()
    {
        return new \XCms\DataStores\ArticleCategory;
    }
}