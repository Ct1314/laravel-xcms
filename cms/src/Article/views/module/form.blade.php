
@if(!empty($module))
    <div class="col-md-12">
        <label for="name">模型名称</label>
        <input type="text" class="form-control" id="name" name="name" value="{{$module->name}}">
    </div>
    <div class="col-md-12">
        <label for="slug">关键字</label>
        <input type="text" class="form-control" id="slug" name="slug" value="{{$module->slug}}">
    </div>
    @else
    <div class="col-md-12">
        <label for="name">模型名称</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="col-md-12">
        <label for="slug">关键字</label>
        <input type="text" class="form-control" id="slug" name="slug">
    </div>
@endif

@push('js')
    {!! Flash::render() !!}
@endpush