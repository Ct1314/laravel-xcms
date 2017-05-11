@extends('admin::layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> Block
        </h1>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="pull-right">
                    <a data-pjax href="{{route('blocks.create')}}" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                    </a>
                </div>
                <a href="{{ route('blocks.index') }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-undo"></i> 刷新
                </a>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-sm"></th>
                        <th class="hidden-sm">名称</th>
                        <th class="hidden-sm">url</th>
                        <th class="hidden-sm">icon</th>
                        <th class="hidden-md">详情</th>
                        <th class="hidden-md">图片</th>
                        <th class="hidden-md">图片列表</th>
                        <th class="hidden-sm">slug</th>
                        <th class="hidden-sm">添加时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($blocks as $block)
                        <tr>
                            <td>{{$block->id}}</td>
                            <td>{{$block->name}}</td>
                            <td><a href="{!! $block->url !!}">{{$block->url}}</a></td>
                            <td>{{$block->icon}}</td>
                            <td>
                                <span class="label label-primary">查看详情</span>
                            </td>
                            <td>
                                @if(!$block->image)
                                    <span>暂无图片</span>
                                @else
                                    <img class="img-thumbnail"
                                         style="max-width:80px;height:110px"
                                         src="{{config('xcms.img.url').$block->image}}">
                                @endif
                            </td>
                            <td>
                                @if(!$block->images)
                                    <span>暂无图片</span>
                                @else
                                    <span class="label label-success">预览</span>
                                @endif
                            </td>
                            <td>{{$block->slug}}</td>
                            <td>{{$block->created_at}}</td>
                            <td>
                                <a href="{{route('blocks.edit',$block->id)}}"
                                   class="btn btn-xs btn-warning">修改</a>
                                <button data-href="{{ route('blocks.destroy',$block->id) }}" class="btn btn-del btn-xs btn-danger">删除</button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                {{$blocks->links()}}
            </div>
            <!-- /.box-body -->
        </div>
    </section>
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
                        确认要删除该block吗?
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
@stop
@push('js')
    {!! Flash::render() !!}
@endpush