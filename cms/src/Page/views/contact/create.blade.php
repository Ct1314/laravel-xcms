@extends('admin::layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 页面
        </h1>
    </section>
    <section class="content">
        @include('admin::layouts.validator-error')
        <form action="{{route('contacts.store')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">联系我们</h3>
                    <div class="box-tools pull-right">
                        <button class="btn-submit btn btn-info btn-sm btn-flat">
                            <i class="fa fa-plus-circle"></i> 保存
                        </button>
                        <a class=" btn btn-default btn-sm btn-flat" href="{{route('contacts.index')}}">
                            <i class="fa fa-plus-circle"></i> 取消
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    @include('page::contact.form')
                </div>
            </div>
        </form>
    </section>
@endsection