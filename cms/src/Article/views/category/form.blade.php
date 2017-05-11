{{csrf_field()}}
<div class="col-md-12">
    <div class="form-group">
        <label for="tag" class=" control-label">名称</label>
        <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="form-group">
        <label for="order" class=" control-label">排序</label>
        <input type="text" class="form-control" name="order" id="order">
    </div>
    {{--<div class="form-group">--}}
        {{--<label for="parent_id" class=" control-label">上级分类</label>--}}
        {{--<select name="parent_id" id="parent_id" class="form-control">--}}
            {{--<option value="">请选择</option>--}}
            {{--@forelse($categories as $category)--}}
                {{--<option value="{{$category->id}}">{{$category->name}}</option>--}}
                {{--@empty--}}
            {{--@endforelse--}}
        {{--</select>--}}
    {{--</div>--}}
    <div class="form-group">
        <label for="status" class=" control-label">状态</label>
        <select name="status" id="status" class="form-control">
            <option value="1">显示</option>
            <option value="0">隐藏</option>
        </select>
    </div>
</div>
