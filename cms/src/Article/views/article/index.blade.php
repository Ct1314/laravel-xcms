@extends('admin::layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 文章管理
        </h1>
    </section>
    <section class="content">
        <style>
            img{
                max-width: 100%;
            }
        </style>
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="pull-right">
                    <a data-pjax href="{{route('articles.create')}}" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                    </a>
                </div>
                <a href="{{ route('articles.index') }}" class="btn btn-sm btn-warning">
                    <i class="fa fa-undo"></i> 刷新
                </a>
            </div>

            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-sm">ID</th>
                        <th class="hidden-md">缩略图</th>
                        <th class="hidden-sm">名称</th>
                        <th class="hidden-sm">所属分类</th>
                        <th class="hidden-sm">所属模型</th>
                        <th class="hidden-sm">标签</th>
                        <th class="hidden-md">详情</th>
                        <th class="hidden-sm">添加时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($arts as $art)
                        <tr>
                            <td>{{$art->id}}</td>
                            <td>
                                @if(!$art->thumb)
                                    <span class="label label-warning">暂无数据</span>
                                @else
                                    <img class="img-thumbnail"
                                         style="max-width:80px;height:110px"
                                         src="{{config('xcms.img.url').$art->thumb}}">
                                @endif
                            </td>
                            <td>
                                @if(strlen($art->name) > 10 )
                                    {{mb_substr($art->name,0,5)}}.....
                                @else
                                    {{$art->name}}
                                @endif
                            </td>
                            <td>
                                @if(!empty($art->category->name))
                                    <span class="label label-info">{{$art->category->name}}</span>
                                @else
                                    <span class="label label-danger">不属于任何分类</span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($art->module->name))
                                    <span class="label label-info">{{$art->module->name}}</span>
                                @else
                                    <span class="label label-warning">不属于任何模型</span>
                                @endif
                            </td>
                            <td>
                                <?php $tags = explode(',',$art->tag) ?>
                                @foreach($tags as $tag)
                                    <span class="label label-info">{{$tag}}</span>
                                @endforeach
                            </td>

                            <td>
                                <button data-index="{{$art->id}}" class="btn-Body btn btn-xs btn-success">查看详情</button>
                            </td>
                            <td>{{$art->created_at}}</td>
                            <td>
                                <a href="{{route('articles.edit',$art->id)}}"
                                   class="btn btn-xs btn-warning">修改</a>
                                <button  data-href="{{route('articles.destroy',$art->id)}}" class="btn btn-xs btn-del btn-danger">删除</button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                {{$arts->links()}}
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
                            确定要删除该文章吗?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form class="deleteForm" method="POST" action="">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i>取消</button>
                            <button type="submit" class="btn btn-danger">确认</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{--modal-article-body--}}
        <div class="modal fade" id="modal-body" tabIndex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" id="article-title">
                        <button type="button" class="close" data-dismiss="modal">
                            ×
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="lead" id="article-body"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i>取消</button>
                        <button type="button" class="btn btn-danger"  data-dismiss="modal">确认</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    {!! Flash::render() !!}
    <script>
        $('.table').delegate('.btn-Body','click',function () {
           var id = $(this).attr('data-index');
           $.ajax({
               url:'/admin/article/'+id+'/body',
               beforeSend:function () {
                   NProgress.start();
               },
               success:function (res) {
                   NProgress.done();
                   if(res.success) {
                       $('#article-body').html(res.body);
                       $('#article-title').text(res.title);
                       $('#modal-body').modal();
                   }else {
                       toastr.error(res.success);
                   }
               }
           });
        });
    </script>
@endpush