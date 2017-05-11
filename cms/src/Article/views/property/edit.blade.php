@extends('admin::layouts.index')



@section('content-header')

@stop
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 文章属性
        </h1>
    </section>
    <section class="content">
        <form action="{{route('properties.update',$property->id)}}" method="post">
            {{ method_field('PUT') }}
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    <div class="box-tools pull-right">
                        <button class=" btn btn-info btn-sm btn-flat">
                            <i class="fa fa-save"></i> 保存
                        </button>
                        <a class=" btn btn-default btn-sm btn-flat" href="{{route('properties.index')}}">
                            <i class="fa fa-remove"></i> 取消
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @include('article::property.form')
                </div>
            </div>
        </form>
    </section>
@stop
