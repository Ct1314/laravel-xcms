@extends('admin::layouts.index')

@section('title','Block Manage')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> Block分类
        </h1>
    </section>
   <section class="content">
       @include('admin::layouts.validator-error')
       <form action="{{ route('blockCategories.update',$category->id) }}" method="POST">
           {{ csrf_field( )}} {{ method_field('PUT') }}
           <div class="box box-info">
               <div class="box-header with-border">
                   <h3 class="box-title"> Block </h3>
                   <div class="box-tools pull-right">
                       <button class="btn btn-info btn-sm btn-flat btn-submit">
                           <i class="fa fa-plus-circle"></i> 保存
                       </button>
                       <a class=" btn btn-default btn-sm btn-flat" href="{{route('blockCategories.index')}}">
                           <i class="fa fa-remove"></i> 取消
                       </a>
                   </div>
               </div>
               <div class="box-body">
                   @include('block::category.form')
               </div>
           </div>
       </form>
   </section>
@stop
@section('js')

@endsection