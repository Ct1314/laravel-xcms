<?php

namespace XCms\Page\Controllers;
/*
* name AboutController.php
* user Yuanchang.xu
* date 2017/5/4
*/

use Flash;
use XCms\BaseController;
use Illuminate\Http\Request;
use XCms\Page\Models\Contact;
use Watson\Validating\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactController extends BaseController
{
    public function index()
    {
        $contacts  = Contact::paginate(10);
        return view('page::contact.index',compact('contacts'));
    }

    public function create()
    {
        return view('page::contact.create');
    }

    public function store(Request $request)
    {
        $contactModel = new Contact;
        try {
            $contactModel->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        }
        return redirect(route('contacts.index'));
    }

    public function edit($id)
    {
        try {
            $contact = Contact::findOrFail($id);
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该页面不存在');
            return redirect(route('contacts.index'));
        }
        return view('page::contact.edit',compact('contact'));
    }

    public function update($id,Request $request)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->fill($request->all())->saveOrFail();
            Flash::success('保存成功');
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该页面不存在');
            return redirect(route('contacts.index'));
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->getErrors());
        }
        return redirect(route('contacts.index'));
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contact->delete();
            Flash::success('删除成功');
        } catch (ModelNotFoundException $modelNotFoundException) {
            Flash::warning('该页面不存在');
            return redirect(route('contacts.index'));
        }
        return redirect(route('contacts.index'));
    }
    public function getBody($id)
    {
        try {

            $about = Contact::findOrFail($id,['body']);
            return [
                'success'=>true,
                'message'=>'获取成功',
                'data'=>$about
            ];
        } catch(ModelNotFoundException $modelNotFoundException) {
            return [
                'success'=>false,
                'message'=>'没有获取到信息'
            ];
        }
    }
}