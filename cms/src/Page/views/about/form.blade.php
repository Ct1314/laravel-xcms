@if(!empty($about))
<div class="form-group">
    <label for="name" class=" control-label">名称</label>
    <input type="text" class="form-control required" name="name" id="name" value="{{ $about->name }}">
</div>
<div class="form-group">
    <label for="slug" class=" control-label">标识</label>
    <input type="text" class="form-control required" name="slug" id="slug" value="{{ $about->slug }}">
</div>
<div class="form-group">
    <label for="body" class=" control-label">内容</label>
    <textarea name="body" id="body" cols="30" rows="10" class="form-control required">{!! $about->body !!}</textarea>
</div>
@else
<div class="form-group">
    <label for="name" class=" control-label">名称</label>
    <input type="text" class="form-control required" name="name" id="name">
</div>
<div class="form-group">
    <label for="slug" class=" control-label">标识</label>
    <input type="text" class="form-control required" name="slug" id="slug">
</div>
<div class="form-group">
    <label for="body" class=" control-label">内容</label>
    <textarea name="body" id="body" cols="30" rows="10" class="form-control required"></textarea>
</div>
@endif

@push('css')
<link rel="stylesheet" href="{{ asset('/packages/xcms/summernote/summernote.css') }}">
@endpush

@push('js')
<script src="{{ asset('/packages/xcms/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('/packages/xcms/summernote/lang/summernote-zh-CN.js') }}"></script>
<script>
    $('#body').summernote({
        lang:'zh-CN',
        height:300
    });
</script>
@endpush