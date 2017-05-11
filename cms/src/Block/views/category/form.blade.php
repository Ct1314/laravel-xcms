@if(!empty($category))
    <div class="col-md-12">
        <div class="form-group">
            <label for="tag" class=" control-label">名称</label>
            <input type="text" class="form-control required" name="name" id="tag" value="{{$category->name}}">
        </div>
        <div class="form-group">
            <label for="slug" class=" control-label">slug</label>
            <input type="text" class="form-control" name="slug" id="slug"  value="{{$category->slug}}">
        </div>
        <div class="form-group">
            <label for="title" class=" control-label">标题</label>
            <input type="text" class="form-control required" name="title" id="title" value="{{$category->title}}">
        </div>
        <div class="form-group">
            <label for="status" class=" control-label">状态</label>
            <select name="status" id="status" class="form-control required" >
                <option value="hide" {{$category->status == 'hide'?"selected":""}}>隐藏</option>
                <option value="show"  {{$category->status == 'show'?"selected":""}}>显示</option>
            </select>
        </div>
        <div class="form-group">
            <label for="details" class=" control-label">详情</label>
            <textarea name="details" id="details"> {{$category->description}}</textarea>
        </div>
    </div>
@else
    <div class="col-md-12">
        <div class="form-group">
            <label for="tag" class=" control-label">名称</label>
            <input type="text" class="form-control" name="name" id="tag">
        </div>
        <div class="form-group">
            <label for="slug" class=" control-label">标识</label>
            <input type="text" class="form-control" name="slug" id="slug">
        </div>
        <div class="form-group">
            <label for="title" class=" control-label">标题</label>
            <input type="text" class="form-control" name="title" id="title">
        </div>
        <div class="form-group">
            <label for="status" class=" control-label">状态</label>
            <select name="status" id="status" class="form-control">
                <option value="hide">隐藏</option>
                <option value="show">显示</option>
            </select>
        </div>
        <div class="form-group">
            <label for="details" class=" control-label">详情</label>
            <textarea name="details" id="details"></textarea>
        </div>
    </div>
@endif


@push('css')
<link rel="stylesheet" href="{{ asset('/packages/xcms/summernote/summernote.css') }}">
@endpush

@push('js')
<script src="{{ asset('/packages/xcms/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('/packages/xcms/summernote/lang/summernote-zh-CN.js') }}"></script>
<script>
    $('#details').summernote({
        lang:'zh-CN',
        height:300
    });
</script>
@endpush