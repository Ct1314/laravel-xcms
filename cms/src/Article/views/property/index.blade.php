@extends('admin::layouts.index')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 文章属性
        </h1>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"> 文章属性</h3>
                <div class="box-tools pull-right">
                    <a class=" btn btn-primary btn-sm btn-flat" href="{{route('properties.create')}}">
                        <i class="fa fa-plus-circle"></i> 添加
                    </a>
                </div>
            </div>
        </div>
        <div class="box  box-info box-solid">
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-sm">ID</th>
                        <th class="hidden-sm">排序</th>
                        <th class="hidden-sm">添加时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($properties as $property)
                        <tr>
                            <td>{{$property->id}}</td>
                            <td>{{$property->name}}</td>
                            <td>{{$property->order}}</td>
                            <td>{{$property->created_at}}</td>
                            <td>
                                <a href="{{route('properties.edit',$property->id)}}" class="btn btn-xs btn-warning">修改</a>
                                <button class="btn btn-del btn-xs btn-danger" data-index="{{$property->id}}">删除</button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                {{$properties->links()}}
            </div>
            <!-- /.box-body -->
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
                            确定要删除该文章属性吗?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form id="delForm" method="POST" action="">
                            {{csrf_field()}}
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i>取消</button>
                            <button type="submit" class="btn btn-danger">确认</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('js')
    {!! Flash::render() !!}
    <script>
        $('.table').delegate('.btn-del','click',function () {
            var id = $(this).attr('data-index');
            $('#delForm').attr('action','/admin/article/property/'+id)
            $("#modal-delete").modal();
        });
    </script>
@endsection