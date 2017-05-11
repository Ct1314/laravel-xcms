@if(!empty($link))
<div class="form-group">
    <label for="name" class=" control-label">名称</label>
    <input type="text" class="form-control required" name="name" id="name" value="{{ $link->name }}">
</div>
<div class="form-group">
    <label for="url" class=" control-label">链接</label>
    <input type="text" class="form-control required" name="url" id="url" value="{{ $link->url }}">
</div>
<div class="form-group">
    <label for="order" class=" control-label">排序</label>
    <input type="text" class="form-control" name="order" id="order" value="{{ $link->order }}">
</div>
<div class="form-group">
    <label for="description" class=" control-label">内容</label>
    <textarea name="description" id="description" cols="30" rows="10" class="form-control required">{{ $link->description }}</textarea>
</div>
@else
<div class="form-group">
    <label for="name" class=" control-label">名称</label>
    <input type="text" class="form-control required" name="name" id="name">
</div>
<div class="form-group">
    <label for="url" class=" control-label">链接</label>
    <input type="text" class="form-control required" name="url" id="url">
</div>
<div class="form-group">
    <label for="order" class=" control-label">排序</label>
    <input type="text" class="form-control" name="order" id="order">
</div>
<div class="form-group">
    <label for="description" class=" control-label">内容</label>
    <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
</div>
@endif
