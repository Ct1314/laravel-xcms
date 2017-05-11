@include('layouts.error')
@if(!empty($config))
    @else
<div>
    <div class="col-md-12">
        <div class="form-group">
                <label for="banner" class=" control-label">图片1</label>
                <input type="file" class="form-control required" name="file" id="banner">
        </div>
        <div class="form-group">
            <label for="order" class="control-label">排序</label>
            <input type="text" class="form-control required" name="order" id="order">
        </div>
        <div class="form-group">
            <label for="link" class="control-label">链接</label>
            <input type="text" class="form-control required" name="link" id="link">
        </div>
    </div>
</div>
@endif

@section('css')
@endsection
@section('js')
    {!! Flash::render() !!}
    <script>
       function banner() {
           upload.init($('input[name="file"]'),{
               uploadUrl:'/admin/banner/upload/image'
           });
           upload.event($('input[name="file"]'),'/admin/delete/resource','banner');
       }
       banner();
    </script>
@endsection