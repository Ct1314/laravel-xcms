<?php

namespace XCms\Setting\Models;


/*
* 
* name 
* author Yuanchang
* date 
*/
use Flash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use XCms\Core\Exception\XCmsException;

class Banner extends Model {
    /**
     * @var array
     */
    protected $fillable = ['banner','link','order'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @name storeBanner
     * @desc
     * @param array $data
     * @author Yuanchang
     * @since 2017.04.
     * @throws XCmsException
     */
    public function storeBanner(array $data,$id = null)
    {
        if($id)
        {
            $banner = $this->find($id);

            if ( $banner->banner == null && empty($data['banner']) )
            {
                throw new XCmsException('轮播图不能为空!');
            }

            $banner->fill($data)->save();

            $this->toggleCache();

            return;
        }

        if(empty($data['banner'])) throw new XCmsException('轮播图不能为空!');

        $this->fill($data)->save();

        $this->toggleCache();
    }

    /**
     * @name toggleCache
     * @desc
     * @author Yuanchang
     * @since 2017.04.
     */
    public function toggleCache()
    {
        $banners = $this->orderBy('order','desc')->skip(0)->take(5)->get(['id','order','link','banner']);
        if(Cache::has('banners'))
        {
            Cache::forget('banners');
            Cache::forever('banners',serialize($banners));
        }
        else
        {
            Cache::forever('banners',serialize($banners));
        }
    }

}