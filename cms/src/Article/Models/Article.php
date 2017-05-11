<?php namespace XCms\Article\Models;


use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use ValidatingTrait;
    /**
     * @var array
     */
    protected $fillable = [
        'tag',
        'body',
        'name',
        'video',
        'thumb',
        'title',
        'order',
        'author',
        'keyword',
        'module_id',
        'abstract',
        'is_comment',
        'category_id',
        'browse_count',
        'is_watermark',
    ];

    // validator rules
    /**
     * @var array
     */
    public $rules = [
        'name'=>'required',
        'title'=>'required',
        'body'=>'required',
        'order'=>'required|numeric',
        'tag'=>'max:255',
        'browse_count'=>'numeric',
    ];

    public function module()
    {
        return $this->belongsTo('XCms\Article\Models\Module','module_id');
    }

    /**
     * @name category
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo('XCms\Article\Models\Category','category_id');
    }

    /**
     * @name properties
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @return mixed
     */
    public function properties()
    {
        return $this->belongsToMany('XCms\Article\Models\Property','article_properties','article_id','property_id');
    }

    /**
     * @name saveArticle
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param array $data
     * @param Article|null $article
     * @return mixed
     */
    public function saveArticle(array $data,Article $article = null)
    {
        if($article)
        {

            $article->fill($data)->save();
        }

        $this->fill($data)->save();
    }
}