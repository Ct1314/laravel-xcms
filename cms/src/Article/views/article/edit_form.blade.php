<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#base" data-toggle="tab">文章</a></li>
    <li role="presentation"><a href="#advance" data-toggle="tab">高级参数</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="base">
        <div style="margin-top: 30px;">
            <div class="form-group">
                <!-- name Form Input  -->
                <label for="name" class="col-md-2 control-label">名称</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="name" value="{{$art->name}}" name="name">
                </div>
            </div>
            <div class="form-group">
                <label for="tag" class="control-label col-md-2">文章标签</label>
                <div class="col-md-8">
                    <input type="text" id="tag" class="form-control" name="tag" placeholder="输入后按下回车确认" value="{{$art->tag}}">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-md-2 control-label">文章标题</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="title" value="{{$art->title}}" name="title">
                </div>
            </div>
            <div class="form-group">
                <!-- name Form Input  -->
                <label for="order" class="col-md-2 control-label">排序</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="order"  name="order" value="{{$art->order}}">
                </div>
            </div>
            <div class="form-group">
                <label for="module_id" class="col-md-2 control-label">选择文章模型</label>
                <div class="col-md-8">
                    <select name="module_id" id="module_id" class="form-control">
                        <option value="0">整站</option>
                        @forelse($modules as $module)
                            <option value="{{$module->id}}"
                                    {{$module->id == $art->module_id? "selected":""}}
                            >{{$module->name}}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="category_id" class="control-label col-md-2">选择文章分类</label>
                <div class="col-md-8">
                    <select name="category_id" id="category_id" class="form-control">
                        @forelse($categories as $category)
                            <option value="{{$category->id}}" {{$category->id == $art->category_id?"selected":''}}>
                                {{str_repeat('&nbsp;',$category->depth).$category->name}}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="thumb" class="control-label col-md-2">文章缩略图</label>
                <div class="col-md-8">
                    <input type="file"  name="file" class="form-control required" id="thumb">
                </div>
            </div>
            <div class="form-group">
                <label for="video" class=" control-label col-md-2">视频</label>
                <div class="col-md-8">
                    <input type="file" class="form-control required" name="file" id="video">
                </div>
            </div>
            <div class="form-group">
                <label for="abstract" class="control-label col-md-2">文章摘要</label>
                <div class="col-md-8">
                    <textarea name="abstract" id="abstract" cols="30" rows="10" class="form-control">{{$art->abstract}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="ue-continer" class="control-label col-md-2">内容</label>
                <div class="col-md-8">
                    <textarea name="body"  id="ue-continer">{!! $art->body !!}</textarea>
                </div>
            </div>

        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="advance">
        <div style="margin-top: 30px;">
            <div class="form-group">
                <label for="is_comment_0" class="col-md-2 control-label">开启评论</label>
                <div class="col-md-8">
                    <label class="radio-inline" for="is_comment_1">
                        <input type="radio" name="is_comment" value="1" id="is_comment_1"
                                {{$art->is_comment == 1?"checked":""}}
                        > 允许评论
                    </label>
                    <label class="radio-inline" for="is_comment_0"
                            {{$art->is_comment == 0?"checked":""}}
                    >
                        <input type="radio" name="is_comment" value="0" id="is_comment_0"> 禁止评论
                    </label>
                </div>
            </div>
            <div class="form-group">
                <!-- browse_count Form Input  -->
                <label for="browse_count" class="col-md-2 control-label">浏览次数</label>
                <div class="col-md-8">
                    <input type="text" id="browse_count" class="form-control" name="browse_count" value="{{$art->browse_count}}">
                </div>
            </div>
            <div class="form-group">
                <!-- author Form Input  -->
                <label for="author" class="col-md-2 control-label">作者</label>
                <div class="col-md-8">
                    <input type="text" id="author" class="form-control" name="author" value="{{$art->author}}">
                </div>
            </div>
            <div class="form-group">
                <label for="keyword" class=" control-label col-md-2">关键字(','号分开)</label>
                <div class="col-md-8">
                    <input type="text" class="form-control required" name="keyword" id="keyword" value="{{$art->keyword}}">
                </div>
            </div>
        </div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="{{ asset('/packages/xcms/sliptree-bootstrap-tokenfield/dist/css/bootstrap-tokenfield.min.css') }}">
@endpush
@push('js')
<script src="{{ asset('/packages/xcms/ueditor/ueditor.config.js') }}"></script>
<script src="{{ asset('/packages/xcms/ueditor/ueditor.all.min.js') }}"></script>
<script src="{{ asset('/packages/xcms/sliptree-bootstrap-tokenfield/dist/bootstrap-tokenfield.min.js') }}"></script>
<script>
    UE.getEditor('ue-continer',{
        initialFrameHeight:'500'
    });
    $('#tag').tokenfield({
        showAutocompleteOnFocus: true
    })
    {!! $thumb !!}
    {!! $video !!}
</script>
@endpush