@extends('admin::layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 文章内容模型
        </h1>
    </section>
    <section class="content">
        @include('admin::layouts.validator-error')
        <form action="{{route('modules.store')}}" method="post">
            {{ csrf_field() }}
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> Block </h3>
                    <div class="box-tools pull-right">
                        <button class="btn-submit btn btn-info btn-sm btn-flat">
                            <i class="fa fa-save"></i> 保存
                        </button>
                        <a class=" btn btn-default btn-sm btn-flat" href="{{route('modules.index')}}">
                            <i class="fa fa-remove"></i> 取消
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @include('article::module.form')
                </div>
            </div>
        </form>
    </section>

@stop