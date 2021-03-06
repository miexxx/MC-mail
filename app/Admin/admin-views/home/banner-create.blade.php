@extends('admin::layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">创建</h3>
                    <div class="box-tools">
                        <div class="btn-group pull-right" style="margin-right: 10px">
                            <a href="{{ route('admin::banners.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;列表</a>
                        </div> <div class="btn-group pull-right" style="margin-right: 10px">
                            <a class="btn btn-sm btn-default form-history-back"><i class="fa fa-arrow-left"></i>&nbsp;返回</a>
                        </div>
                    </div>
                </div>

                <form id="post-form" class="form-horizontal" action="{{ route('admin::banners.store') }}" method="post" enctype="multipart/form-data" pjax-container>
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="order" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="order" name="order" value="0" class="form-control order" placeholder="输入 排序">
                                </div>
                            </div>
                        </div>
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="banner" class="col-sm-2 control-label">轮播图</label>
                                <div class="col-sm-8">
                                    <input type="file" class="banner" name="banner" id="banner" accept="image/*">
                                    <span class="help-block">建议尺寸：640*350，请将轮播图尺寸大小保持一致</span>
                                </div>
                            </div>
                        </div>
                        <div class="fields-group">
                            <div class="form-group">
                                <label for="type" class="col-sm-2 control-label">类型</label>
                                <div class="col-sm-8">
                                    <select class="form-control type" style="width: 100%;" id="select-type" name="type" data-placeholder="选择 类型"  >
                                        <option value="">请选择</option>
                                        @foreach($types as $k => $type)
                                            <option value="{{ $k }}" >{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="target" class="col-sm-2 control-label">目标</label>

                            <div class="col-sm-8">
                                    <input type="hidden" id="target" name="target" class="form-control target">
                                    <input type="text" id="faker_target" class="form-control" placeholder="输入 目标" style="width: 100%;">
                                <span class="help-block">根据选择的类型填写本字段内容，选择“链接”需填写完整链接地址</span>
                            </div>
                        </div>

                        <div class="" id="list_box2" style="width: 50%;margin: auto;display: none">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search_key" style="height: 34px">
                                <span class="input-group-btn">
                                    <button id="search_btn" class="btn btn-default"  type="button" value="搜索">
                                    搜索
                                    </button>
                                </span>
                                {{--<input type="button" id="search_btn" class="btn btn-info pull-right" value="搜索">--}}
                            </div>
                            <div id="list-view" style="overflow-y:auto;height: 300px">
                                <table class="table">
                                    <tbody id="list_menu">
                                    <tr>
                                        <th>ID</th>
                                        <th>图片</th>
                                        <th>编号</th>
                                        <th>商品标题</th>
                                        <th>状态</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="list-btn">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">启用</label>
                            <div class="col-sm-8">
                                <input type="checkbox" class="status la_checkbox" checked/>
                                <input type="hidden" class="status" name="status" value="1"/>
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

            $(".order").bootstrapNumber({
                'upClass': 'success',
                'downClass': 'primary',
                'center': true
            });

            $(".banner").fileinput({
                overwriteInitial: false,
                initialPreviewAsData: true,
                browseLabel: "浏览",
                showRemove: false,
                showUpload: false,
                allowedFileTypes: [
                    "image"
                ]
            });

            $(".type").select2({
                "allowClear": true
            });

            $('.status.la_checkbox').bootstrapSwitch({
                size:'small',
                onText: '是',
                offText: '否',
                onColor: 'primary',
                offColor: 'danger',
                onSwitchChange: function(event, state) {
                    $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
                }
            });

            ///
            $("#post-form").bootstrapValidator({
                live: 'enable',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    type:{
                        validators:{
                            notEmpty:{
                                message: '请选择类型'
                            }
                        }
                    },
                    target:{
                        validators:{
                            notEmpty:{
                                message:'请填写目标'
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



            $('body').on('click','.item-tr',function () {
                var id = $(this).children("td").html();
                var title = $(this).children("td").eq(3).html();
                $("#target").val(id);
                $("#faker_target").val("您所选择的商品为："+title);
            })

            $("#select-type").bind("change",function(){
                var typename = $(this).val();
                if (typename == "goods"){
                    $('#list_box2').show();
                    $("#faker_target").attr("disabled","disabled");
                }else {
                    $('#list_box2').hide();
                    $("#faker_target").removeAttr("disabled");
                }
            });
            $('#find-list').on('click',function () {
                $('#list_box2').toggle();
            })

            $('#search_btn').on('click',function () {
                creatlist(this);
            });

            $('body').on('click','#page',function () {
                creatlist(this);
            });
        });
        function creatlist(th) {
            $('.item-tr').remove();
            $("#list-btn-main").remove();
            var html  = '';
            var html2 = '';
            var key = $('#search_key').val();
            var page = $(th).attr('pageid');
            $.ajax({
                url:"/items/search",
                type:"post",
                data:{
                    keyword:key,
                    page:page?page:1,
                },
                success:function (data) {
                    $('.item-tr').remove();
                    $("#list-btn-main").remove();
                    var items = data.data;
                    $(items).each(function (index,value) {
                        index +=1;
                        html +=  "<tr class='item-tr' style=\"cursor: pointer;\"><td>"+index+"</td>";
                        html +=  "<td><img src='"+value['url']+"' width='50' class='img-circle' height='50'/></td>";
                        html +=  "<td>"+value['sn']+"</td>";
                        html +=  "<td>"+value['title']+"</td>";
                        html +=  "<td><span class=\"label label-primary\">"+value['status']+"</span></td></tr>";
                    })

                    html2 +="<div id='list-btn-main' class=\"box-footer\"><ul class=\"pagination pagination-sm no-margin pull-right\">";
                    for (var i=1;i<=data.last_page;i++)
                    {
                        html2 += "<li style=\"cursor: pointer;\"><span id=\"page\" pageid='"+i+"' >"+i+"</span></li>";
                    }
                    html2 += "</ul></div>";
                    $("#list_menu").append(html);
                    $("#list-btn").append(html2);
                }
            });
        }
    </script>
@endsection