@extends('admin.layouts.base')

@section('content-header')
    <h1>
        <i class="fa fa-file-text-o"></i> 配置 <small>轮播图管理</small>
    </h1>
    {!! Breadcrumbs::render('banner') !!}
@stop
@section('content')
    <div id="block-block-entry">
        <div class="box box-primary">
            <div class="box-header">
                <a class="btn btn-flat btn-primary" href="{{route('admin.banner.create')}}">设置</a>
            </div>
            <div class="box-body">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    @forelse($banners as $index=>$banner)
                        @if($banner->banner)
                        <div class="swiper-slide">
                            <a href="{{route('admin.banner.edit',$banner->id)}}">
                                <img src="{{DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$banner->banner}}" alt="">
                            </a>
                        </div>
                            @else
                                <div class="swiper-slide" style="background: #4390EE">
                                    <a href="{{route('admin.banner.edit',$banner->id)}}">轮播图1还没有图片,点击设置</a>
                                </div>
                        @endif
                        @empty
                            <div class="swiper-slide" style="background: #4390EE">图1</div>
                            <div class="swiper-slide" style="background: #CA4041">图2</div>
                            <div class="swiper-slide" style="background: #FF8604">图3</div>
                            <div class="swiper-slide" style="background: #00a65a">图4</div>
                            <div class="swiper-slide" style="background: #50D4FD">图5</div>
                    @endforelse
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>

    </div>
@stop
@section('css')
    <style>
        .swiper-container {
            width: 800px;
            height: 400px;
        }
        .swiper-slide{
            color: #fff;
            line-height: 300px;
            text-align: center;
            font-size: 50px;
        }
        .swiper-slide a {
            color: #fff;
            font-size: 50px;
        }
    </style>
    <link rel="stylesheet" href="/plugins/Swiper-3.4.2/dist/css/swiper.min.css">
@endsection
@section('js')
    <script src="/plugins/Swiper-3.4.2/dist/js/swiper.min.js"></script>
    <script>
       new Swiper ('.swiper-container', {
            loop : true,
            autoplay: 3000,
            pagination : '.swiper-pagination',
            mousewheelControl : true,
            grabCursor : true,
           preventClicks : true
        });
       upload.init($('#config-banner'),{
            maxFileCount:4
       });
    </script>
    {!! Flash::render() !!}
@endsection