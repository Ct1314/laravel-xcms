@extends('admin::layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 关于我们页面
        </h1>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="pull-right">
                    <a data-pjax href="{{route('abouts.create')}}" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                    </a>
                </div>
                <a href="{{ route('abouts.index') }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-undo"></i> 刷新
                </a>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-sm"></th>
                        <th class="hidden-sm">名称</th>
                        <th class="hidden-sm">标识</th>
                        <th class="hidden-sm">内容</th>
                        <th class="hidden-sm">添加时间</th>
                        <th class="hidden-sm">修改时间时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($abouts as $about)
                        <tr>
                            <td>{{ $about->id }}</td>
                            <td>{{ $about->name }}</td>
                            <td>{{ $about->slug }}</td>
                            <td>
                                <button class="btn btn-xs btn-info btn-body" 
                                data-href="{{ url('/admin/abouts/'.$about->id.'/getBody') }}">查看详情</button>
                            </td>
                            <td>{{ $about->created_at }}</td>
                            <td>{{ $about->updated_at }}</td>
                            <td>
                                <a href="{{ route('abouts.edit',$about->id) }}" class="btn btn-xs btn-warning">修改</a>
                                <button data-href="{{ route('abouts.destroy',$about->id) }}"  class="btn btn-del btn-xs btn-danger">删除</button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                {{ $abouts->links() }}
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
                        确认要删除该页面吗?
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
    {{--modal-about-body--}}
    <div class="modal fade" id="modal-body" tabIndex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" id="about-title">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    <p class="lead" id="about-body">
                        
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i>取消</button>
                    <button type="button" class="btn btn-danger"  data-dismiss="modal">确认</button>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
{!! Flash::render() !!}
<script type="text/javascript">
    $('table').delegate('.btn-body','click',function(){
        var href = $(this).attr('data-href');
        $.ajax({
            url:href,
            method:'POST',
            data:{_token:'{{ csrf_token() }}'},
            success:function(res){
                if (res.success) {
                    $('#about-body').html(res.data.body);
                    $('#modal-body').modal();
                } else
                    toastr.error(res.message);
            }
        })
    });
</script>
@endpush