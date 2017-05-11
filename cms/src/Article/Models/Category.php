<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/4/13
 * Time: 14:12
 */

namespace XCms\Article\Models;


use Baum\Node;
use Watson\Validating\ValidatingTrait;

/**
 * Class Category
 * @package XCms\Article\App\Models
 */
class Category extends Node
{

    use ValidatingTrait;

    protected $table = 'article_categories';
    /**
     * @var string
     */
    protected $parentColumn = 'parent_id';

    /**
     * @var string
     */
    protected $leftColumn = 'lft';

    /**
     * @var string
     */
    protected $rightColumn = 'rgt';

    /**
     * @var string
     */
    protected $depthColumn = 'depth';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'parent_id', 'name', 'lft', 'rgt','depth','status','order'
    ];

    /**
     * @var array
     */
    public $rules = [
        'name'=>'required|unique:article_categories',
        'order'=>'required|numeric',
        'status'=>'required'
    ];

    /**
     * @name articles
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @return mixed
     */
    public function articles()
    {
        return $this->hasMany('XCms\Article\Models\Article','category_id');
    }
}