<?php
/**
 * Created by PhpStorm.
 * User: yuanchang
 * Date: 2017/4/10
 * Time: 11:28
 */

namespace XCms\Block\Controllers;

use Admin;
use Flash;
use Storage;
use Breadcrumbs;
use Upload\Core\Image;
use Upload\Core\Upload;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Block\Models\Block;
use XCms\Traits\DeleteResource;
use XCms\Block\Models\BlockCategory;
use Watson\Validating\ValidationException;
use Upload\Exceptions\FileUploadException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlockController extends BaseController
{
    use DeleteResource;

    /**
     * render file input config
     * @var array
     */
    protected $img = [
        'id'=>'image',
        'hidden'=>'image',
        'maxFileCount'=>1,
        'maxFileSize'=>'2048',
        'allowedPreviewTypes'=>['image'],
        "allowedFileExtensions"=>['gif','jpeg','png','jpg'],
        'uploadUrl'=>'/admin/block/upload/image',
    ];

    /**
     * @name index
     * @desc show block page
     * @author Yuanchang.xu
     * @version v1.0.0
     * @since 2017.05.
     * @return mixed
     */
    public function index()
    {
        $blocks = Block::orderBy('order','desc')->paginate(10);
        return view('block::block.index',['blocks'=>$blocks]);
    }

    /**
     * @name create
     * @desc create block form page
     * @author Yuanchang.xu
     * @version v1.0.0
     * @since 2017.05.04
     * @return mixed
     */
    public function create()
    {
        // image render
        $image = Admin::FileInput($this->img, function($fileInput){
            return $fileInput->render();
        }
        );
        //categories
        $categories = BlockCategory::all();
        // if category notfound
        if (count($categories) <= 0) {
            return view('admin::errors.notfound')->with(['url'=>route('blockCategories.create'),'message'=>'添加Block分类']);
        }
        return view('block::block.create',compact('categories','image'));
    }

    /**
     * @name store
     * @desc store block to db
     * @author Yuanchang.xu
     * @version v1.0.0
     * @since 2017.05.04
     * @param Request $request
     * @return mixed
     * @exception Watson\Validating\ValidationException
     */
    public function store(Request $request)
    {
        $model = new Block();
        try {
            $model->fill( $request->all() )->saveOrFail();
            Flash::success('保存成功');
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        }
        return redirect(route('blocks.index'));
    }

    /**
     * @name edit
     * @desc edit block form page
     * @author Yuanchang.xu
     * @version v1.0.0
     * @since 2017.05.04
     * @param $id
     * @return mixed
     * @exception Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function edit($id)
    {
        // get block and block category for db
        $categories = BlockCategory::all();
        try {
            $block = Block::findOrFail($id);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该block不存在');
            return redirect( route('blocks.index') );
        }
        $config = config('xcms');
        // image render
        $imagePreview = [];
        $imagePreviewConfig = [];
        if ($block->image) {
            $imagePreview = [ $config['img']['url'].$block->image ];
            $imagePreviewConfig  = [
                [
                    'url'=>'/admin/block/delete/'.$block->id.'/image',
                    'extra'=>['path'=>$block->image,'_token'=>csrf_token()]
                ]
            ];
        }
        $image = Admin::FileInput($this->img,function($fileInput) use ($imagePreview,$imagePreviewConfig) {
            return $fileInput->preview($imagePreview,$imagePreviewConfig)->render();
        }
        );
        return view('block::block.edit',compact('block','categories','image'));
    }

    /**
     * @name update
     * @desc update block to db
     * @author Yuanchang.xu
     * @version v1.0.0
     * @since 2017.05.04
     * @param Request $request
     * @param $id
     * @return mixed
     * @exception Watson\Validating\ValidationException
     * @exception Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(Request $request,$id)
    {
        $inputs = $request->all();
        try {
            $block = Block::findOrFail($id);
            if (empty($inputs['image'])) {
                $inputs['image'] = $block->image;
            }
            $block->fill($inputs)->saveOrFail();
            Flash::success("保存成功");
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该block不存在');
        }
        return redirect(route('blocks.index'));
    }

    /**
     * @name destroy
     * @desc delete block to db
     * @author Yuanchang.xu
     * @version v1.0.0
     * @since 2017.05.
     * @param $id
     * @return mixed
     * @exception Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function destroy($id)
    {
        try {
            $block = Block::findOrFail($id);
            $block->delete();
            $this->delete('image',$block->image);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该block不存在');
        }
        Flash::success('删除成功');
        return redirect( route('blocks.index') );
    }

    /**
     * @name uploadImage
     * @desc upload image
     * @author Yuanchang.xu
     * @version v1.0.0
     * @since 2017.05.04
     * @param Request $request
     * @return mixed
     * @exception FileUpload\Exceptions\FileUploadException
     */
    public function uploadImage(Request $request)
    {
        try {
            $path = (new Upload(
                new Image($request->file('image'))
            )
            )->save()->path;
        } catch (FileUploadException $fileUploadException) {
            return response()->json([
                    'success'=>false,
                    'message'=>$fileUploadException->getMessage()
                ]
            );
        }
        return [
            'success'=>true,
            'message'=>'上传成功',
            'path'=>$path,
        ];
    }

    /**
     * @name deleteImage
     * @desc delete block image
     * @author Yuanchang.xu
     * @version v1.0.0
     * @since 2017.05.
     * @param Request $request
     * @param $id
     * @return mixed
     * @exception Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteImage(Request $request,$id)
    {
        $path = $request->get('path');
        try {
            $block = Block::findOrFail($id);
            $block->image = null;
            $block->saveOrFail();
            $this->delete('image',$path);
        } catch (ModelNotFoundException $modelNotFoundException) {
            return response()->json([
                'success'=>true,
                'message'=>'删除失败,该block不存在',
            ]);
        }
    }
}