@extends('admin::layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> Block
        </h1>
    </section>
    <section class="content">
        <form action="{{route('blocks.update',['id'=>$block->id])}}" method="POST">
            {{ csrf_field() }}{{ method_field('PUT') }}
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> Block </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-info btn-sm btn-flat">
                            <i class="fa fa-plus-circle"></i> 保存
                        </button>
                        <a class=" btn btn-default btn-sm btn-flat" href="{{route('blocks.index')}}">
                            <i class="fa fa-plus-circle"></i> 取消
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @include('block::block.edit_form')
                </div>
            </div>
        </form>
    </section>
@stop
@section('js')

@endsection
