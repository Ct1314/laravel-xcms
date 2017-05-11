@extends('admin::layouts.index')
@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-file-text-o"></i> 文章分类管理
        </h1>
    </section>
    <section class="content">
        <div class="col-md-5">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title">分类列表</h3>
                    <div class="box-tools pull-right">
                        <a type="button" href="{{route('categories.create')}}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus-circle"></i> 添加分类
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <ul id="category-tree" class="ztree"></ul>
                    {{csrf_field()}}
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> 管理 </h3>
                    <div class="box-tools pull-right" id="category-manage">
                        <button class="btn btn-addsub btn-success btn-sm">
                            <i class="fa fa-plus-circle"></i>
                            添加下级分类
                        </button>
                        <button class="btn-edit btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square"></i> 编辑
                        </button>
                        <button class="btn-delete btn btn-sm btn-danger" href="http://xcms.dev/admin/block">
                            <i class="fa fa-times-circle"></i> 删除
                        </button>
                    </div>
                    <div class="box-tools pull-right" id="category-edit" style="display: none">
                        <button class="btn-save btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square"></i> 保存
                        </button>
                        <button class=" btn btn-cancel btn-sm btn-default">
                            <i class="fa fa-times-circle"></i> 取消
                        </button>
                    </div>
                    <div class="box-tools pull-right" id="category-addsub" style="display: none">
                        <button class="btn-substore btn btn-primary btn-sm">
                            <i class="fa fa-pencil-square"></i> 保存
                        </button>
                        <button class=" btn btn-cancel btn-sm btn-default">
                            <i class="fa fa-times-circle"></i> 取消
                        </button>
                    </div>
                </div>
                <div class="box-body" id="category-form">
                    <form id="categoryForm">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="control-label">分类名称</label>
                                <input type="text" name="name" id="name" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="control-label">分类排序</label>
                                <input type="text" name="order" id="order" readonly class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="control-label">状态</label>
                                <select name="status" id="status" readonly class="form-control">
                                    <option value="">请选择</option>
                                    <option value="1">显示</option>
                                    <option value="0">隐藏</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{--"modal-delete--}}
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog modal-danger">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">提示：危险操作</h4>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        确认要删除该分类吗?
                    </p>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" id="confirm-delete" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i> 确认
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('/packages/admin/zTree_v3/css/zTreeStyle/zTreeStyle.css') }}">
@endpush
@push('js')
    <script src="{{ asset('/packages/admin/zTree_v3/js/jquery.ztree.core.min.js') }}"></script>
    <script>
        var token = $('meta[name="_token"]').attr('content');
        // tree设置
        var setting = {
            async: {
                enable: true,
                type:'POST',
                url: "/admin/categories/all",
                otherParam: { _token:token}
            },
            data:{
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                }
            },
            view: {
                showLine: false,
                showIcon: false
            },
            callback: {
                beforeAsync: function () {
                    NProgress.start();
                },
                onAsyncSuccess: function () {
                    NProgress.done();
                    treeObj.expandAll(true);

                },
                onClick: function(event,id,node){
                    action(node);
                }
            }
        };
        $.fn.zTree.init($("#category-tree"), setting);
        var treeObj = $.fn.zTree.getZTreeObj("category-tree");
        treeObj.expandAll(true);
        function action(row) {
            /*修改*/
            edit(row);
            /*保存*/
            update(row);
            /*删除*/
            destroy(row);
            /*添加下级分类*/
            addSub(row);
        }
        function edit(row) {
            manageShow();readonly();
            /*设置值*/
            $('#name').val(row.name);
            $('#order').val(row.order);
            $.each($('#status option'),function (val,item) {
                if($(item).val() == row.status) {
                    $(item)[0].selected = true;
                }
            });
            /*编辑*/
            $('.btn-edit').on('click',function () {
                editShow();closeReadonly();
            });

        }
        function update(row) {
            $('.btn-save').on('click',function(){
                var fd = new FormData($('#categoryForm')[0]);
                var data = {name:fd.get('name'),order:fd.get('order'),status:fd.get('status'),'_token':token,'_method':'PUT'}
                $.ajax({
                    url:'/admin/categories/'+row.id,
                    method:'post',
                    data:data,
                    beforeSend:function () {
                        NProgress.start();
                    },
                    success:function (res) {
                        NProgress.done();
                        if(res.success) {
                            toastr.success(res.message);
                            readonly();
                            manageShow();
                        }else{
                            toastr.error(res.message);
                        }
                    }
                });
            });
            $('.btn-cancel').on('click',function () {
                readonly();
                manageShow();
            });
        }
        function destroy(row) {
            $('.btn-delete').on('click',function () {
                $('#modal-delete').modal();
                $('#confirm-delete').one('click',function () {
                    $.ajax({
                        url:'/admin/categories/'+row.id,
                        method:'post',
                        data:{'_method':'DELETE','_token':token},
                        beforeSend:function () {
                            NProgress.start();
                        },
                        success:function (res) {
                            NProgress.done();
                            $('#modal-delete').modal('hide')
                            if(res.success) {
                                toastr.success(res.message);
                            }else{
                                toastr.error(res.message);
                            }
                        }
                    });
                })
            });
        }
        function addSub(row) {
            $('.btn-addsub').on('click',function () {
                closeReadonly(true);
                $('#category-edit').hide();
                $('#category-manage').hide();
                $('#category-addsub').show();
            });
            $('.btn-substore').on('click',function () {
                var fd = new FormData($('#categoryForm')[0]);
                var data = {name:fd.get('name'),order:fd.get('order'),status:fd.get('status')}
                console.log(data);
                $.ajax({
                    url:'/admin/categories/'+row.id+'/sub',
                    method:'POST',
                    data:data,
                    headers:{
                        'X-CSRF-TOKEN':'{{csrf_token()}}'
                    },
                    beforeSend:function () {
                        loadShow();
                    },
                    success:function (res) {
                        loadFadeOut();
                        if(res.success) {
                            toastr.success(res.message);
                            readonly();
                            manageShow();
                        }else{
                            if(res.errors) {
                                $.each(res.errors,function(key,error) {
                                    toastr.error(error);
                                });
                                return;
                            }
                            toastr.error(res.message);
                            return;

                        }
                    }
                });
            });
        }
        function readonly() {
            $('#categoryForm input').attr('readonly','true');
            $('#categoryForm select').attr('readonly','true');
        }
        function closeReadonly(empty) {
            $('#categoryForm input').removeAttr('readonly');
            $('#categoryForm select').removeAttr('readonly');
            if(empty) {
                $('#categoryForm input').val('');
                $('#categoryForm select option').removeAttr('selected');
            }
        }
        function manageShow() {
            $('#category-edit').hide();
            $('#category-manage').show();
        }
        function editShow() {
            $('#category-manage').hide();
            $('#category-edit').show();
        }
    </script>
@endpush