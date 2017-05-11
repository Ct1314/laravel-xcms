<?php

namespace XCms\DataStores;

interface Datastore
{
    /**
     * @name get
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $key
     * @param array $columns
     */
    public function get($key, array $columns = ["*"]);

    /**
     * @name all
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ["*"]);

    /**
     * @name paginate
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $number
     * @return mixed
     */
    public function paginate($number);
}