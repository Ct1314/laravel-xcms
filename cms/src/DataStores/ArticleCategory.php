<?php
namespace XCms\DataStores;

/*
* name ArticleCategory.php
* user Yuanchang.xu
* date 2017/4/21
*/

use XCms\Article\Models\Article as Art;
use XCms\Article\Models\Category as ArtCat;

class ArticleCategory implements Datastore
{

    /**
     * @var
     */
    protected $data;

    /**
     * @name get
     * @desc get data
     * @author Yuanchang.xu
     * @since 2017
     * @param $key
     * @param array $columns
     * @return mixed
     */
    public function get($key, array $columns = ["*"])
    {
        $artCat = ArtCat::find($key,$columns);

        $this->data =  $artCat? : null;

        return $this;
    }

    /**
     * @name getRoot
     * @desc According to id get root node
     * @author Yuanchang.xu
     * @since 2017
     * @param $key
     * @param array $columns
     * @return mixed
     */
    public function root($key,$columns = ["*"])
    {
        $artCat = ArtCat::find($key,$columns);

        $this->data =  $artCat? $artCat->isRoot()? $artCat : null : null;

        return $this;
    }

    /**
     * @name all
     * @desc Get all
     * @author Yuanchang.xu
     * @since 2017
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ["*"])
    {
        return ArtCat::all($columns);
    }

    /**
     * @name allRoot
     * @desc Get all root node
     * @author Yuanchang.xu
     * @since 2017
     * @param array $columns
     * @return mixed
     */
    public function allRoot( array $columns = ["*"])
    {
        return ArtCat::roots()->get($columns);
    }


    /**
     * @name children
     * @desc Get the child node according to the root node
     * @author Yuanchang.xu
     * @since 2017
     * @param array $columns
     * @return mixed
     */
    public function children( array $columns = ["*"])
    {
        if($this->data) {
            return $this->data->descendants()->get($columns);
        }
        return null;
    }


    /**
     * @name childrenDepth
     * @desc Get the child node according to the root node and limit the acquisition level
     * @author Yuanchang.xu
     * @since 2017
     * @param $number
     * @param array $columns
     * @return mixed
     */
    public function childrenDepth($number,array $columns = ["*"])
    {
        if($this->data && is_numeric($number)) {
            return $this->data->descendants()->limitDepth($number)->get($columns);
        }
        return null;
    }

    /**
     * @name paginate
     * @desc Get all and paginate
     * @author Yuanchang.xu
     * @since 2017
     * @param $number
     * @return mixed
     */
    public function paginate($number)
    {
        return ArtCat::paginate($number);
    }

    /**
     * @name catByArt
     * @desc According to article id get article category
     * @author Yuanchang.xu
     * @since 2017
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function catByArt($id,array $columns = ["*"])
    {
        $art = Art::find($id);

        if (!$art)
        {
            return null;
        }
        $cat = ArtCat::find($art->category_id,$columns);

        return $cat? $cat : null;
    }
}