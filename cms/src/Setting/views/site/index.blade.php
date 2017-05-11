@extends('admin::layouts.index')
@section('content')
    <section class="content-header">

    </section>
    <section class="content">
        @include('admin::layouts.validator-error')
        <form action="{{ route('site.store') }}" method="POST">
            <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"> Block </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-info btn-sm ">
                        <i class="fa fa-save"></i> 保存
                    </button>
                    <a class=" btn btn-default btn-sm" href="{{route('admin')}}">
                        <i class="fa fa-remove"></i> 取消
                    </a>
                </div>
            </div>
            <div class="box-body">
                    {{ csrf_field() }}
                    @if ($site)
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="icp" class=" control-label">ICP备案信息</label>
                                <input type="text" class="form-control required" name="icp" id="icp" value="{{ $site->icp }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="copyright" class="control-label">版权信息</label>
                                <textarea name="copyright" id="copyright" class="form-control" cols="30" rows="10" style="resize: none">{{ $site->copyright }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="code" class="control-label">第三方流量统计代码</label>
                                <textarea name="code" id="code" class="form-control" cols="30" rows="10" style="resize: none">{{ $site->code }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="icp" class=" control-label">站点状态</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ $site->status == 1?"selected":"" }}>开启</option>
                                    <option value="0" {{ $site->status == 0?"selected":"" }}>关闭</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="close_cause" class="control-label">关闭原因</label>
                                <textarea name="close_cause" id="close_cause" cols="30" rows="10">{{ $site->close_cause}}</textarea>
                            </div>
                        </div>
                        @else
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="icp" class=" control-label">ICP备案信息</label>
                                <input type="text" class="form-control required" name="icp" id="icp" value="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="copyright" class="control-label">版权信息</label>
                                <textarea name="copyright" id="copyright" class="form-control" cols="30" rows="10" style="resize: none"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="code" class="control-label">第三方流量统计代码</label>
                                <textarea name="code" id="code" class="form-control" cols="30" rows="10" style="resize: none"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="icp" class=" control-label">站点状态</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" >开启</option>
                                    <option value="0" >关闭</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="close_cause" class="control-label">关闭原因</label>
                                <textarea name="close_cause" id="close_cause" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    @endif
            </div>
        </div>
        </form>
    </section>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('/packages/xcms/summernote/summernote.css') }}">
@endpush

@push('js')
    {!! Flash::render() !!}
    <script src="{{ asset('/packages/xcms/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('/packages/xcms/summernote/lang/summernote-zh-CN.js') }}"></script>
    <script>
        $('#close_cause').summernote({
            lang:'zh-CN',
            height:300
        });
    </script>
@endpush