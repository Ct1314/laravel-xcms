@if(!empty($contact))
<div class="form-group">
    <label for="name" class=" control-label">名称</label>
    <input type="text" class="form-control required" name="name" id="name" value="{{ $contact->name }}">
</div>
<div class="form-group">
    <label for="slug" class=" control-label">标识</label>
    <input type="text" class="form-control required" name="slug" id="slug" value="{{ $contact->slug }}">
</div>
<div class="form-group">
    <label for="mobile" class=" control-label">手机号</label>
    <input type="text" class="form-control required" name="mobile" id="mobile" value="{{ $contact->mobile }}">
</div>
<div class="form-group">
    <label for="tel" class=" control-label">电话号</label>
    <input type="text" class="form-control required" name="tel" id="tel" value="{{ $contact->tel }}">
</div>
<div class="form-group">
    <label for="email" class=" control-label">邮箱</label>
    <input type="text" class="form-control required" name="email" id="email" value="{{ $contact->email }}">
</div>
<div class="form-group">
    <label for="wx" class=" control-label">微信</label>
    <input type="text" class="form-control required" name="wx" id="wx" value="{{ $contact->wx }}">
</div>
<div class="form-group">
    <label for="qq" class=" control-label">QQ</label>
    <input type="text" class="form-control required" name="qq" id="qq" value="{{ $contact->qq }}">
</div>
<div class="form-group">
    <label for="url" class=" control-label">内容</label>
    <textarea name="body" id="body" cols="30" rows="10" class="form-control required">{!! $contact->body !!}</textarea>
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
    <label for="mobile" class=" control-label">手机号</label>
    <input type="text" class="form-control required" name="mobile" id="mobile">
</div>
<div class="form-group">
    <label for="tel" class=" control-label">电话号</label>
    <input type="text" class="form-control required" name="tel" id="tel">
</div>
<div class="form-group">
    <label for="email" class=" control-label">邮箱</label>
    <input type="text" class="form-control required" name="email" id="email">
</div>
<div class="form-group">
    <label for="wx" class=" control-label">微信</label>
    <input type="text" class="form-control required" name="wx" id="wx">
</div>
<div class="form-group">
    <label for="qq" class=" control-label">QQ</label>
    <input type="text" class="form-control required" name="qq" id="qq">
</div>
<div class="form-group">
    <label for="url" class=" control-label">内容</label>
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