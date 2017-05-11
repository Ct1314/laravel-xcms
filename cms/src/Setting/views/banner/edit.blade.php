@extends('admin.layouts.base')

@section('title','title')
@section('content-header')
    <h1>
        <i class="fa fa-file-text-o"></i> 轮播图 <small>Banner create</small>
    </h1>
    {!! Breadcrumbs::render('banner.edit') !!}
@stop
@section('content')
    <div id="block-block-entry">
        <form action="{{route('admin.banner.update',$banner->id)}}" method="post">
            {{csrf_field()}}
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> Block </h3>
                    <div class="box-tools pull-right">
                        <button class="btn-submit btn btn-info btn-sm btn-flat">
                            <i class="fa fa-plus-circle"></i> 保存
                        </button>
                        <a class=" btn btn-default btn-sm btn-flat" href="{{route('admin.banner.index')}}">
                            <i class="fa fa-plus-circle"></i> 取消
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for="banner" class=" control-label">图片1</label>
                                <input type="file" class="form-control required" name="file" id="banner">
                            </div>
                            <div class="col-md-4">
                                <label for="banner_order" class="control-label">排序</label>
                                <input type="text" class="form-control required" name="order" id="banner_order" value="{{$banner->order}}">
                            </div>
                            <div class="col-md-4">
                                <label for="banner_link" class="control-label">链接</label>
                                <input type="text" class="form-control required" name="link" id="banner_link" value="{{$banner->link}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@section('js')
    {!! Flash::render() !!}
    <script>
        var initialPreview = [];
        var initialPreviewConfig = [];
        @if($banner->banner)
            var banner = {!! json_encode($banner->banner) !!};

            initialPreview = [
                '<img src="{{asset('uploads')}}/'+banner+'" style="width:300px;height:200px;">'
            ];
            initialPreviewConfig =  [
                {
                    width: '120px',
                    url: '{{route('admin.banner.delete.image')}}',
                    extra: {path: banner,_token:$('meta[name="_token"]').attr('content'),id:'{{$banner->id}}'}
                }
            ];

        @endif
        upload.init($('#banner'),{
            uploadUrl:'/admin/banner/upload/image',
            initialPreview:initialPreview,
            initialPreviewConfig:initialPreviewConfig
        });
        upload.event($('#banner'),'/admin/delete/resource','banner')
    </script>
    @endsection