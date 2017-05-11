{{csrf_field()}}
@if(!empty($property))
    <div class="col-md-12">
        <!-- name Form Input  -->
        <label for="name">文章属性名称</label>
        <input type="text" class="form-control" id="name"  name="name" value="{{$property->name}}">
        <label for="order">文章属性排序</label>
        <input type="text" class="form-control" id="order"  name="order" value="{{$property->order}}">
    </div>
    @else
        <label for="name">文章属性名称</label>
        <input type="text" class="form-control" id="name"  name="name">
        <label for="order">文章属性排序</label>
        <input type="text" class="form-control" id="order" name="order">
@endif
@push('js')
    {!! Flash::render() !!}
@endpush