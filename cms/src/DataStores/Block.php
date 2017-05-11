<?php namespace

XCms\DataStores;

/*
* name Block.php
* user Yuanchang.xu
* date 2017/4/20
*/

use XCms\Block\Models\Block as B;
use XCms\Block\Models\BlockCategory;

class Block implements DataStore
{


    /**
     * @name get
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $key
     * @param array $columns
     */
    public function get($key,array $columns = ["*"])
    {
        return B::where('id',$key)->orWhere('slug',$key)->get($columns);
    }

    /**
     * @name all
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ["*"])
    {
        return B::all($columns);
    }

    /**
     * @name paginate
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return B::paginate($number);
    }


    /**
     * @name toCat
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function byCat($id,array $columns = ["*"])
    {
        $bc = BlockCategory::find($id);

        if(!$bc) {
            return null;
        }

        return $bc->blocks()->get($columns);
    }
}