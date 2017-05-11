@include('admin::layouts.validator-error')
{{csrf_field()}}
@if(!empty($art))
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
                   <label for="" class="col-md-2 control-label">文章属性</label>
                   <div class="col-md-8">
                       @forelse($properties as $property)
                           <label for="property_id_{{$property->id}}" class="checkbox-inline">
                               <input type="checkbox" id="property_id_{{$property->id}}" value="{{$property->id}}" name="property_id[]"
                                      {{in_array($property->id,$properties_id)?"checked":""}}
                               > {{$property->name}}
                           </label>
                       @empty
                           <a href="{{route('admin.article.property.create')}}" class="btn btn-xs btn-info">暂无,点击添加</a>
                       @endforelse
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
                   <label for="simple_title" class="col-md-2 control-label">文章简略标题</label>
                   <div class="col-md-8">
                       <input type="text" class="form-control" id="simple_title" value="{{$art->simple_title}}" name="simple_title">
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
                       <input type="file" class="form-control" name="file" id="video">
                   </div>
               </div>
               <div class="form-group">
                   <label for="description" class="control-label col-md-2">简介</label>
                   <div class="col-md-8">
                       <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{$art->description}}</textarea>
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
                            {{$art->is_comment == 1?"selected":""}}
                            > 允许评论
                        </label>
                        <label class="radio-inline" for="is_comment_0"
                                {{$art->is_comment == 0?"selected":""}}
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
                    <label for="author" class="col-md-2 control-label">浏览次数</label>
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
                <div class="form-group">
                    <label for="abstract" class="col-md-2 control-label">内容摘要</label>
                    <div class="col-md-8">
                        <textarea name="abstract" id="abstract" cols="30" rows="10" class="form-control">{{$art->abstract}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div>
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
                            <input type="text" class="form-control" id="name"  name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">文章属性</label>
                        <div class="col-md-8">
                            @forelse($properties as $property)
                                <label for="property_id_{{$property->id}}" class="checkbox-inline">
                                    <input type="checkbox" id="property_id_{{$property->id}}" value="{{$property->id}}" name="property_id[]"> {{$property->name}}
                                </label>
                                @empty
                                <a href="{{route('admin.article.property.create')}}" class="btn btn-xs btn-info">暂无,点击添加</a>
                            @endforelse
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tag" class="control-label col-md-2">文章标签</label>
                        <div class="col-md-8">
                            <input type="text" name="8" id="tag" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-2 control-label">文章标题</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="title"  name="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="simple_title" class="col-md-2 control-label">文章简略标题</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="simple_title"  name="simple_title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="module_id" class="col-md-2 control-label">选择文章模型</label>
                        <div class="col-md-8">
                            <select name="module_id" id="module_id" class="form-control">
                                <option value="0">整站</option>
                                @forelse($modules as $module)
                                    <option value="{{$module->id}}">{{$module->name}}</option>
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
                                    <option value="{{$category->id}}">
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
                            <input type="file" class="form-control" name="file" id="video">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label col-md-2">简介</label>
                        <div class="col-md-8">
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ue-continer" class="control-label col-md-2">内容</label>
                        <div class="col-md-8">
                            <textarea name="body"  id="ue-continer"></textarea>
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
                                <input type="radio" name="is_comment" value="1" id="is_comment_1"> 允许评论
                            </label>
                            <label class="radio-inline" for="is_comment_0">
                                <input type="radio" name="is_comment" value="0" id="is_comment_0"> 禁止评论
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- browse_count Form Input  -->
                        <label for="browse_count" class="col-md-2 control-label">浏览次数</label>
                        <div class="col-md-8">
                            <input type="text" id="browse_count" class="form-control" name="browse_count">
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- author Form Input  -->
                        <label for="author" class="col-md-2 control-label">浏览次数</label>
                        <div class="col-md-8">
                            <input type="text" id="author" class="form-control" name="author">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keyword" class=" control-label col-md-2">关键字(','号分开)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control required" name="keyword" id="keyword" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="abstract" class="col-md-2 control-label">内容摘要</label>
                        <div class="col-md-8">
                            <textarea name="abstract" id="abstract" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
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
        function video() {
            @if(!empty($art->video))
            var videoPath = {!! json_encode($art->video) !!}
            var preview = ["{{asset('/uploads')}}/"+videoPath],       // 预览视频
                previewConfig =  [{
                    type: "video",
                    filetype: "video/mp4",
                    url: "{{route('admin.article.delete.resource')}}",
                    extra:{'path':videoPath,'id':"{{$art->id}}",'_token':"{{csrf_token()}}",'field':'video'},
                }] // 预览配置
            @else
            var preview = [],       // 预览视频
                previewConfig = []; // 预览配置
            @endif
            var el = $('#video');
            upload.init(el,{
                allowedFileTypes:["video"],
                allowedFileExtensions:['mp4','webm','ogg'],
                uploadUrl:'/admin/article/upload/video',
                initialPreview:preview,
                initialPreviewConfig: previewConfig,
                initialPreviewAsData: true,
                initialPreviewFileType: 'image'
            });
            upload.event(el,'/admin/delete/resource','video');
        }
        function thumb() {
            @if(!empty($art->thumb))
            var thumbPath = {!! json_encode($art->thumb) !!}
            var preview = ["{{asset('/uploads')}}/"+thumbPath],       // 预览视频
                previewConfig =  [{
                    type: "image",
                    url: "{{route('admin.article.delete.resource')}}",
                    extra:{'path':thumbPath,'id':"{{$art->id}}",'_token':"{{csrf_token()}}",'field':'thumb'},
                }] // 预览配置
                @else
            var preview = [],       // 预览视频
                previewConfig = []; // 预览配置
            @endif

            var el = $('#thumb');
            upload.init(el,{
                uploadUrl:'/admin/article/upload/thumb',
                initialPreview:preview,
                initialPreviewConfig: previewConfig,
                allowedFileTypes:["image"],
                allowedFileExtensions:['jpg','gif','jpeg','png'],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image'
            });
            upload.event(el,'/admin/article/delete/resource','thumb');
        }
        video();
        thumb();

    </script>
@endpush