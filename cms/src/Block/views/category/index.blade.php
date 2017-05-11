@extends('admin::layouts.index')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> Block 分类
        </h1>
    </section>
    <section class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="pull-right">
                    <a data-pjax href="{{route('blockCategories.create')}}" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                    </a>
                </div>
                <a href="{{ route('blockCategories.index') }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-undo"></i> 刷新
                </a>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th data-sortable="false" class="hidden-sm"></th>
                        <th class="hidden-sm">名称</th>
                        <th class="hidden-sm">slug</th>
                        <th class="hidden-sm">标题</th>
                        <th class="hidden-md">状态</th>
                        <th class="hidden-md">创建日期</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->slug}}</td>
                            <td>{{$category->title}}</td>
                            <td>{{$category->status}}</td>
                            <td>{{$category->created_at}}</td>
                            <td>
                                <a href="{{route('blockCategories.edit',$category->id)}}" class="btn btn-xs btn-warning">修改</a>
                                <button data-href="{{route('blockCategories.destroy',$category->id)}}" class="btn-del btn btn-xs btn-danger">删除</button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                {{$categories->links()}}
            </div>
            <!-- /.box-body -->
        </div>
        {{--"modal-delete--}}
        <div class="modal fade" id="modal-delete" tabIndex="-1">
            <div class="modal-dialog modal-danger">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="modal-title">提示：危险操作</h4>
                    </div>
                    <div class="modal-body">
                        <p class="lead">
                            <i class="fa fa-question-circle fa-lg"></i>
                            确认要删除该分类吗?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form class="deleteForm" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-times-circle"></i> 确认
                            </button>
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