<?php
namespace XCms\DataStores;

/*
* name Article.php
* user Yuanchang.xu
* date 2017/4/21
*/
use XCms\Article\Models\Module;
use XCms\Events\HtmlCacheEvent;
use Illuminate\Filesystem\Filesystem;
use XCms\Article\Models\Article as Art;
use XCms\Article\Models\Category as ArtCat;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Article extends ArticleCategory implements Datastore
{

    public $art;

    /**
     * @name get
     * @desc Get one article data
     * @author Yuanchang.xu
     * @since 2017
     * @param $key
     * @param array $columns
     * @return mixed
     */
    public function get($key, array $columns = ["*"])
    {
        $this->art = Art::find($key,$columns);
        return $this;
    }

    /**
     * @name all
     * @desc Get all article data
     * @author Yuanchang.xu
     * @since 2017
     * @param array $columns
     * @return mixed
     */
    public function all(array $columns = ["*"])
    {
        $this->art =  Art::all($columns);
        return $this;
    }

    public function paginate($number)
    {
        return Art::orderBy('order','desc')->paginate($number);
    }

    /**
     * @name artByCat
     * @desc Get articles by category
     * @author Yuanchang.xu
     * @since 2017
     * @param $key
     * @param array $columns
     * @return mixed
     */
    public function artByCat($key, array $columns = ["*"])
    {
        $artCat = ArtCat::find($key,['id']);

        if( !$artCat ) {
            return null;
        }

        $this->art =  $artCat->articles()->get($columns);

        return $this;
    }

    /**
     * @name artByModule
     * @desc Get articles by module
     * @author Yuanchang.xu
     * @since 2017
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function artByModule($id,$columns = ['*'])
    {
        try {
            $module = Module::where('id',$id)->orWhere('slug',$id)->first($columns);
        } catch (ModelNotFoundException $e) {
            return null;
        }
        $this->art = $module->articles()->get($columns);
        return $this;
    }

    /**
     * @name html
     * @desc Get a static page
     * @author Yuanchang.xu
     * @since 2017
     * @return mixed
     */
    public function html()
    {
        $fileSystem = new Filesystem();
        $config = config('xcms.html');
        $html = [];
        if ( count($this->art) <=0 ) return null;   // article is null
        if ( count($this->art)  == 1 ) {            // article is 1
            $file =  $config['prefix'].$this->art->id.$config['ext'];
            if (!$fileSystem->exists($config['root'].$file)) {
                return event(new HtmlCacheEvent($this->art))[0];
            }
            return $fileSystem->get($config['root'].$file);
        }
        // article more then 1
        if( count($this->art) >1 )
        {
            collect($this->art)->each(
                function($art) use(&$html,$config,$fileSystem) {
                    $file = $config['prefix'].$art->id.$config['ext']; // file name
                    if (!$fileSystem->exists($config['root'].$file)) {
                        array_push($html,event(new HtmlCacheEvent($art))[0]);
                    }
                    array_push($html,$fileSystem->get($config['root'].$file));
                }
            );
        }
        return $html;
    }
}