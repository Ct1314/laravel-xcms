@extends('admin.layouts.base')

@section('title','title')
@section('content-header')
    <h1>
        <i class="fa fa-file-text-o"></i> 轮播图 <small>Banner create</small>
    </h1>
    {!! Breadcrumbs::render('banner.create') !!}
@stop
@section('content')
    <div id="block-block-entry">
        <form action="{{route('admin.banner.store')}}" method="post">
            {{csrf_field()}}
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> Block </h3>
                    <div class="box-tools pull-right">
                        <button class="btn-submit btn btn-info btn-sm btn-flat">
                            <i class="fa fa-plus-circle"></i> 保存
                        </button>
                        <a class=" btn btn-default btn-sm btn-flat" href="{{route('admin.banner.index')}}">
                            <i class="fa fa-plus-circle"></i> 取消
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @include('config::banner.form')
                </div>
            </div>
        </form>
    </div>
@stop