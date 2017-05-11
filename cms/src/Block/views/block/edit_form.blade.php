
<div class="col-md-12">
    <div class="form-group">
        <label for="category_id" class=" control-label">选择分类</label>
            <select name="category_id" id="category_id" class="form-control required">
                @foreach($categories as $category)
                <option value="{{$category->id}}" {{$block->category_id == $category->id?"selected":''}}>{{$category->name}}</option>
                @endforeach
            </select>
    </div>
    <div class="form-group">
        <label for="name" class=" control-label">名称</label>
        <input type="text" class="form-control required" name="name" id="name" value="{{$block->name}}">
    </div>
    <div class="form-group">
        <label for="url" class=" control-label">链接</label>
        <input type="text" class="form-control required" name="url" id="url" value="{{$block->url}}">
    </div>
    <div class="form-group">
        <label for="order" class=" control-label">排序</label>
        <input type="text" class="form-control required" name="order" id="order" value="{{$block->order}}">
    </div>
    <div class="form-group">
        <label for="file" class="control-label">图片</label>
        <input type="file" class="form-control required" name="image" id="image">
    </div>
    <div class="form-group">
        <label for="slug" class="control-label">标识</label>
        <input type="text" class="form-control required" name="slug" id="slug" value="{{$block->slug}}">
    </div>
    <div class="form-group">
        <label for="status" class=" control-label">设置状态</label>
            <select name="status" id="status" class="form-control required">
                <option value="hide" {{$block->status =='hide'?"selected":''}}>hide</option>
                <option value="show" {{$block->status == 'show'?"selected":''}}>show</option>
            </select>
    </div>
    <div class="form-group">
        <label for="description" class=" control-label">详情</label>
        <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{$block->description}}</textarea>
    </div>
</div>


@push('css')
<link rel="stylesheet" href="{{ asset('/packages/xcms/summernote/summernote.css') }}">
@endpush

@push('js')
<script src="{{ asset('/packages/xcms/summernote/summernote.min.js') }}"></script>
<script src="{{ asset('/packages/xcms/summernote/lang/summernote-zh-CN.js') }}"></script>
<script>
    {!! $image !!}
    /**
     * 编辑器
     */
    $('#description').summernote({
        lang:'zh-CN',
        height:300
    });
</script>
@endpush
