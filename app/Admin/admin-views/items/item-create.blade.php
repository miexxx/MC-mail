@extends('admin::layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">创建</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{{ route('admin::items.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>
                <form id="post-form" class="form-horizontal" action="{{ route('admin::items.store') }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="title" name="title" value="" class="form-control" placeholder="输入 标题">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sn" class="col-sm-2 control-label">编号</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="sn" name="sn" value="" class="form-control" placeholder="输入 编号">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sn" class="col-sm-2 control-label">排序</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                        <input type="text" id="sort" name="sort" value="" class="form-control" placeholder="输入 排序">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category_id" class="col-sm-2 control-label">分类</label>
                                <div class="col-sm-4">
                                    <select class="form-control top" style="width: 100%;" name="top_id" data-placeholder="选择 分类"  >
                                        <option value="">请选择</option>
                                        @foreach($tops as $top)
                                            <option value="{{ $top->id }}">{{ $top->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control category" style="width: 100%;" name="category_id" data-placeholder="选择 分类"  >
                                        <option value="">请选择</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="covers" class="col-sm-2 control-label">商品图片</label>
                                <div class="col-sm-8">
                                    <input type="file" class="covers" name="covers[]" id="covers" multiple accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="price" class="col-sm-2 control-label">销售价</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="price" name="price" value="0" class="form-control price" placeholder="输入 销售价">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="original_price" class="col-sm-2 control-label">原价</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="original_price" name="original_price" value="0" class="form-control original_price" placeholder="输入 原价">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="freight" class="col-sm-2 control-label">运费</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="freight" name="freight" value="0" class="form-control freight" placeholder="输入 运费">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="stock" class="col-sm-2 control-label">库存</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" id="stock" name="stock" value="0" class="form-control stock" placeholder="输入 库存">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">图文介绍</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div id="editor">
                                        </div>
                                        <textarea name="details" id="details" cols="30" rows="10" hidden></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status" class="col-sm-2 control-label">是否上架</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" class="status la_checkbox" checked/>
                                    <input type="hidden" class="status" name="status" value="1"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group pull-left">
                            <button type="reset" class="btn btn-warning">重置</button>
                        </div>
                        <div class="btn-group pull-right">
                            <button type="submit" id="submit-btn" class="btn btn-info pull-right" data-loading-text="<i class='fa fa-spinner fa-spin'></i> 提交">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $('.form-history-back').on('click', function (event) {
                event.preventDefault();
                history.back();
            });

            $(".covers").fileinput({
                overwriteInitial: false,
                initialPreviewAsData: true,
                browseLabel: "浏览",
                showRemove: false,
                showUpload: false,
                allowedFileTypes: [
                    "image"
                ]
            });

            $(".price").bootstrapNumber({
                'upClass': 'success',
                'downClass': 'primary',
                'center': true
            });

            $(".original_price").bootstrapNumber({
                'upClass': 'success',
                'downClass': 'primary',
                'center': true
            });

            $(".freight").bootstrapNumber({
                'upClass': 'success',
                'downClass': 'primary',
                'center': true
            });

            $(".stock").bootstrapNumber({
                'upClass': 'success',
                'downClass': 'primary',
                'center': true
            });

            $('.status.la_checkbox').bootstrapSwitch({
                size:'small',
                onText: '上架',
                offText: '下架',
                onColor: 'primary',
                offColor: 'danger',
                onSwitchChange: function(event, state) {
                    $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
                }
            });

            $(".top").change(function () {

                var id = $(this).val();
                $.ajax({
                    type:"get",
                    dataType:"json",
                    data:{
                        _token:LA.token
                    },
                    url:"/category/"+id,
                    success: function(data){
                       // console.log(data)
                        var str=" <option value=\"\">请选择</option>";
                        for(var i=0;i<data['data'].length;i++){
                            str = str+" <option value='"+data['data'][i].id+"' >"+data['data'][i].name+"</option>"
                        }
                        $(".category").html(str);
                    }
                });

            });

            ///
            var menus = [
                'head',  // 标题
                'bold',  // 粗体
                'fontSize',  // 字号
                'fontName',  // 字体
                'italic',  // 斜体
                'underline',  // 下划线
                'strikeThrough',  // 删除线
                'foreColor',  // 文字颜色
                'backColor',  // 背景颜色
                'link',  // 插入链接
                'list',  // 列表
                'justify',  // 对齐方式
                'quote',  // 引用
                'emoticon',  // 表情
                'image',  // 插入图片
                'code',  // 插入代码
                'undo',  // 撤销
                'redo'  // 重复
            ];

            var $details = $("#details");
            var editor = new wangEditor('#editor');
            editor.customConfig.zIndex = 100;
            editor.customConfig.menus = menus;
            editor.customConfig.uploadImgShowBase64 = true;
            editor.customConfig.uploadFileName = 'imgs[]';
            editor.customConfig.showLinkImg = false;
            editor.customConfig.uploadImgServer = "{{ route('admin::upload.image') }}";
            editor.customConfig.uploadImgParams = {
                _token:LA.token
            };
            editor.customConfig.onchange = function (html) {
                $details.val(html);
            };

            editor.create();

            ///
            $("#post-form").bootstrapValidator({
                live: 'enable',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    title:{
                        validators:{
                            notEmpty:{
                                message: '请输入标题'
                            }
                        }
                    },
                    sn:{
                        validators:{
                            notEmpty:{
                                message: '请输入编号'
                            }
                        }
                    },
                    sort:{
                        validators:{
                            notEmpty:{
                                message: '请输入排序'
                            }
                        }
                    },
                    category:{
                        validators:{
                            notEmpty:{
                                message:'请选择分类'
                            }
                        }
                    }
                }
            });

            $("#submit-btn").click(function () {
                var $form = $("#post-form");

                $form.bootstrapValidator('validate');
                if ($form.data('bootstrapValidator').isValid()) {
                    $form.submit();
                }
            })
        });
    </script>
@endsection