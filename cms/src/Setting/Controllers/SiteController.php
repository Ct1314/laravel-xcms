<?php namespace XCms\Setting\Controllers;

use Flash;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Setting\Models\Site;
use Watson\Validating\ValidationException;
class SiteController extends BaseController
{
    public function index()
    {
        $site = Site::find(1);
        return view('setting::site.index')->with('site',$site);
    }
    public function store(Request $request)
    {
        $m = new Site;
        $site = Site::find(1);
        if (!$site) {
            $request->offsetSet('id',1);
            try{
                $m->fill( $request->all() )->saveOrFail();
                Flash::success('保存成功');
                return redirect(route('site.index'));
            }catch (ValidationException $validationException) {
                return redirect()->back()->withErrors($validationException->getErrors());
            }
        }
        try{
            $site->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
            return redirect(route('site.index'));
        }catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        }
    }
}