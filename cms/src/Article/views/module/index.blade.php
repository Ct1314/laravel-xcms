@extends('admin::layouts.index')
@section('title','模块')
@section('content-header')

@stop
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 文章内容模型
        </h1>
    </section>
    <section class="content">

        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="pull-right">
                    <a data-pjax href="{{route('modules.create')}}" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                    </a>
                </div>
                <a href="{{ route('modules.index') }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-undo"></i> 刷新
                </a>
            </div>
            <div class="box-body no-padding table-responsive">
                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="hidden-sm"></th>
                        <th class="hidden-sm">名称</th>
                        <th class="hidden-sm">关键字</th>
                        <th class="hidden-sm">添加时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($modules as $module)
                        <tr>
                            <td>{{$module->id}}</td>
                            <td>{{$module->name}}</td>
                            <td>{{$module->slug}}</td>
                            <td>{{$module->created_at}}</td>
                            <td>
                                <a href="{{route('modules.edit',$module->id)}}" class="btn btn-xs btn-warning">修改</a>
                                <button data-href="{{ route('modules.destroy',$module->id)  }}" class="btn btn-del btn-xs btn-danger">删除</button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                {{$modules->links()}}
            </div>
        </div>
        {{--modal-delete--}}
        <div class="modal fade modal-danger" id="modal-delete" tabIndex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="lead">
                            确定要删除该模型吗?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form class="deleteForm" method="POST">
                            {{csrf_field()}} {{ method_field('DELETE') }}
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i>取消</button>
                            <button type="submit" class="btn btn-danger">确认</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@push('js')
    {!! Flash::render() !!}
@endpush