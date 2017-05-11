@extends('admin::layouts.index')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 文章分类 <small>Create  [顶级分类]</small>
        </h1>
    </section>
    <section class="content">
        @include('admin::layouts.validator-error')
        <form action="{{route('categories.store')}}" method="post">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> Block </h3>
                    <div class="box-tools pull-right">
                        <button class=" btn btn-info btn-sm ">
                            <i class="fa fa-save"></i> 保存
                        </button>
                        <a class=" btn btn-default btn-sm" href="{{route('categories.index')}}">
                            <i class="fa fa-remove"></i> 取消
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @include('article::category.form')
                </div>
            </div>
        </form>
    </section>
@stop
@section('js')

@endsection