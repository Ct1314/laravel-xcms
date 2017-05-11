<?php

namespace XCms\Article\Controllers;

use Admin;
use Flash;
use Exception;
use Validator;
use Upload\Core\Image;
use Upload\Core\Upload;
use Upload\Core\Video;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Events\HtmlCacheEvent;
use XCms\Traits\DeleteResource;
use XCms\Article\Models\Module;
use XCms\Article\Models\Article;
use XCms\Article\Models\Category;
use Watson\Validating\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleController extends BaseController
{
    use DeleteResource;

    protected $thumb = [
        'id'=>'thumb',
        'hidden'=>'thumb',
        'maxFileCount'=>1,
        'maxFileSize'=>'2048',
        'allowedPreviewTypes'=>['image'],
        "allowedFileExtensions"=>['gif','jpeg','png','jpg'],
        'uploadUrl'=>'/admin/article/upload/thumb',
    ];

    protected $video = [
        'id'=>'video',
        'hidden'=>'video',
        'maxFileCount'=>1,
        'deleteUrl'=>'/admin/delete/video',
        'maxFileSize'=>'2147483648',
        'allowedPreviewTypes'=>['video'],
        "allowedFileExtensions"=>['mp4','mov'],
        'uploadUrl'=>'/admin/article/upload/video',
        'initialPreviewFileType'=>'video',
        'initialPreviewAsData'=>true,
        'purifyHtml'=>true,
    ];

    public function index()
    {
        $arts = Article::orderBy('order','desc')->paginate(10);
        return view('article::article.index',compact('arts'));
    }


    public function create()
    {
        // render thumb fileinput
        $thumb = Admin::FileInput(
            $this->thumb,function($fileinput){
                return $fileinput->render();
            }
        );
        // render video fileinput
        $video = Admin::FileInput(
            $this->video,function($fileinput){
                return $fileinput->render();
            }
        );
        $categories = Category::all();
        if (count($categories) <= 0) {
             return view('admin::errors.notfound')->with(['message'=>'添加文章分类','url'=>route('categories.index')]);
        }
        $modules = Module::all();
        return view('article::article.create',compact('categories','modules','thumb','video'));
    }

    /**
     * @name store
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $artModel =  new Article;
        try {
            $artModel->fill($request->all())->saveOrFail();
            event(new HtmlCacheEvent($artModel));
            Flash::success('保存成功');
        } catch (Throwable $exception) {
            return redirect()->route( 'articles.create' )->withErrors( '保存失败' );
        } catch (ValidationException $validationException) {
            return redirect()->route( 'articles.create' )->withErrors( $validationException->getErrors() );
        } catch (Exception $e) {
            Flash::warning($e->getMessage());
        }
        return redirect( route('articles.index') );
    }

    /**
     * @name edit
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $categories = Category::get(['id','name']);
        if (count($categories) <= 0) {
            return view('admin::errors.notfound')->with(['message'=>'添加文章分类','url'=>route('categories.index')]);
        }
        try {
            $art = Article::findOrFail($id);
        }catch (ModelNotFoundException $e) {
            Flash::error('该文章不存在','访问失败');
            return redirect( route('articles.index') );
        }
        // render thumb
        $thumbPreview = [];
        $thumbPreviewConfig = [];
        if ($art->thumb) {
            $thumbPreview = [config('xcms.img.url').$art->thumb];
            $thumbPreviewConfig = [
                [
                    'url'=>'/admin/article/delete/'.$art->id.'/thumb',
                    'extra'=>['path'=>$art->thumb,'_token'=>csrf_token()]
                ]
            ];

        }
        $thumb = Admin::FileInput(
            $this->thumb,function($fileinput) use($thumbPreview,$thumbPreviewConfig){
                return $fileinput->preview($thumbPreview,$thumbPreviewConfig)->render();
            }
        );
        // render video
        $videoPreview = [];
        $videoPreviewConfig = [];
        if ($art->video) {
            $videoPreview = [config('xcms.video.url').$art->video];
            $videoPreviewConfig = [
                [
                    'type'=>'video',
                    'url'=>'/admin/article/delete/'.$art->id.'/video',
                    'extra'=>['path'=>$art->video,'_token'=>csrf_token()],
                ]
            ];
        }
        $video = Admin::FileInput(
            $this->video,function($fileinput) use($videoPreview,$videoPreviewConfig){
                return $fileinput->preview($videoPreview,$videoPreviewConfig,false)->render();
            }
        );
        $modules = Module::all();
        return view('article::article.edit',compact('art','categories','modules','thumb','video'));
    }

    public function update($id,Request $request)
    {
        $inputs = $request->all();
        try {
            $art =  Article::findOrFail($id);
            if (empty($inputs['thumb'])) {
                $inputs['thumb'] = $art->thumb;
            }
            if (empty($inputs['video'])) {
                $inputs['video'] = $art->video;
            }
            $art->fill($request->all())->saveOrFail();
            event(new HtmlCacheEvent($art));
            Flash::warning('保存成功');
        }catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该文章不存在');
        }catch (ValidationException $validationException) {
            return redirect()->route( 'articles.edit',$id )->withErrors($validationException->getErrors());
        }catch (Exception $exception) {
            Flash::warning($exception->getMessage());
        }
        return redirect(route('articles.index'));
    }

    /**
     * @name destroy
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $art =  Article::findOrFail($id);
            $art->delete();
            $this->delete('image',$art->thumb);
            $this->delete('video',$art->video);
            $this->html($id);
            Flash::success('删除成功');
        } catch (ModelNotFoundException $e) {
            Flash::warning('该文章不存在');
        }
        return redirect( route('articles.index') );
    }

    /**
     * @name uploadVideo
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param Request $request
     * @return mixed
     */
    public function uploadVideo(Request $request)
    {
        try {
            $upload = new Upload(new Video($request->file('file')));
            $upload->save();
        } catch (FileUploadException $fileUploadException) {
            return response()->json([
                    'success'=>false,
                    'message'=>$fileUploadException->getMessage()
            ]);
        }
        return response()->json([
            'success'=>true,
            'message'=>'上传成功',
            'path'=>$upload->path
        ]);
    }

    public function uploadThumb(Request $request)
    {
        try {
            $upload = new Upload(new Image($request->file('file')));
            $upload->save();
            $path = $upload->path;
        } catch (FileUploadException $fileUploadException) {
            return response()->json([
                    'success'=>false,
                    'message'=>$fileUploadException->getMessage()
            ]);
        }
        return [
            'success'=>true,
            'message'=>'上传成功',
            'path'=>$upload->path,
        ];
    }

    public function deleteVideo(Request $request,$id)
    {
        $path = $request->get('path');
        try {
            $art = Article::findOrFail($id);
            $art->video = null;
            $art->saveOrFail();
            $this->delete('video',$path);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return [
                'success'=>false,
                'message'=>'删除失败,该block不存在',
            ];
        }
        return [
            'success'=>true,
            'message'=>'删除成功',
        ];
    }

    public function deleteThumb(Request $request,$id)
    {
        $path = $request->get('path');
        try {
            $art = Article::findOrFail($id);
            $art->thumb = null;
            $art->saveOrFail();
            $this->delete('image',$path);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return [
                'success'=>false,
                'message'=>'删除失败,该block不存在',
            ];
        }
        return [
            'success'=>true,
            'message'=>'删除成功',
        ];
    }

    /**
     * @name getBody
     * @desc
     * @author Yuanchang.xu
     * @since 2017
     * @param $id
     * @return mixed
     */
    public function getBody($id)
    {
        $article = Article::find($id,['body','title']);

        if(!$article) {
            return response()->json([
                'success'=>false,
                'message'=>'获取失败',
                'body'=>null
            ]);
        }
        return response()->json([
            'success'=>true,
            'message'=>'获取成功',
            'body'=>$article->body,
            'title'=>$article->title,
        ]);
    }



}