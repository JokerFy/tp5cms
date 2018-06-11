$(function () {

    /**
     * 推送JS相关
     */
    $("#finCms-push").click(function(){
        var id = $("#select-push").val();
        if(id==0) {
            return dialog.error("请选择推荐位");
        }
        push = {};
        postData = {};
        $("input[name='pushcheck']:checked").each(function(i){
            push[i] = $(this).val();
        });
        console.log(push);
        postData['model'] = 'position_content';
        postData['push'] = push;
        postData['position_id']  =  id;
        //console.log(postData);return;
        // var url = SCOPE.push_url;
        $.post('/admin/content/push', postData, function(result){
            if(result.status == 1) {
                // TODO
                return dialog.success(result.message,result['data']['jump_url']);
            }
            if(result.status == 0) {
                // TODO
                return dialog.error(result.message);
            }
        },"json");

    });

    /**
     * 排序操作
     */
    $('#button-listorder').click(function () {
        // 获取 listorder内容
        var inputs=$('#tabodyform').find("input[type='text']");
        postData = {};
        $(inputs).each(function(i){
            postData[this.name] = this.value;
        });
        postData['table'] = SCOPE.model;
        $.post('/admin/base/listorder', postData, function (result) {
            if (result.status === 1) {
                //成功
                return dialog.success(result.message);
            } else if (result.status === 0) {
                // 失败
                return dialog.error(result.message);
            }
        }, "JSON");
    });


    /**
     * 提交form表单操作
     */
    layui.use(['form','upload'], function() {
        var upload = layui.upload,layer = layui.layer, form = layui.form;

        form.on('submit(lay-finCms-form)', function(data){
            var datas = $("#finCms-form").serializeArray();
            postData = {};
            $(datas).each(function (i) {
                postData[this.name] = this.value;
            });

            if(!SCOPE.save_url){
                SCOPE.save_url = '/admin/base/curd';
            }
            postData['table'] = SCOPE.model;
            postData['methodType'] = SCOPE.methodType; //add：添加，upload:编辑
            // 将获取到的数据post给服务器
            url =  SCOPE.save_url;
            jump_url = '';
            $.post(url, postData, function (result) {
                if (result.status === 1) {
                    //成功
                    return dialog.successon(result.message);
                } else if (result.status === 0) {
                    // 失败
                    return dialog.error(result.message);
                }
            }, "JSON");

            return false;
        });

        /*
         编辑模型
          */
    /*    form.on('submit(finCms-form-edit)', function(data){
            alert('123');
            var datas = $("#finCms-form").serializeArray();
            postData = {};
            $(datas).each(function (i) {
                postData[this.name] = this.value;
            });
            postData['table'] = SCOPE.model;
            postData['methodType'] = 'update';
            url = '/admin/base/curd';
            jump_url = SCOPE.jump_url;
            $.post(url, postData, function (result) {
                if (result.status === 1) {
                    //成功
                    return dialog.successon(result.message,jump_url);
                } else if (result.status === 0) {
                    // 失败
                    return dialog.error(result.message,jump_url);
                }
            }, "JSON");

            return false;
        });*/

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            , url: 'http://tp5cms.cn/api/v1/image/toupload'
            , before: function (obj) {
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#demo1').attr('src', result); //图片链接（base64）
                    $('#demo1').attr('width', '100px');
                    $('#demo1').attr('height', '100px');
                });
            }
            , done: function (res) {
                if (res.status === 1) {
                    res.image = '/'+res.data;
                    $("#imgName").val(res.image);
                    return layer.msg('上传成功');
                } else if (res.status === 0) {
                    return layer.msg('上传失败');
                }
            }

            , error: function () {
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> ');
            }
        });

    });


/*        $("#finCms-form-submit").click(function () {
            var data = $("#finCms-form").serializeArray();
            postData = {};
            $(data).each(function (i) {
                postData[this.name] = this.value;
            });
            console.log(postData);
            // 将获取到的数据post给服务器
            url = SCOPE.save_url;
            jump_url = '';
            $.post(url, postData, function (result) {
                if (result.status === 1) {
                    //成功
                    return dialog.successon(result.message);
                } else if (result.status === 0) {
                    // 失败
                    return dialog.error(result.message);
                }
            }, "JSON");
        });*/

/*
                //监听提交
        form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            layer.alert("增加成功", {icon: 6},function () {
                // 获得frame索引
                var index = parent.layer.getFrameIndex(window.name);
                //关闭当前frame
                parent.layer.close(index);
            });
            return false;
        });
*/





    /*
    编辑模型
     */
    $('#finCms-form-edit').on('click', function () {
        var data = $("#finCms-form").serializeArray();
        postData = {};
        $(data).each(function (i) {
            postData[this.name] = this.value;
        });
        postData['table'] = SCOPE.model;
        postData['methodType'] = 'update';
        url = '/admin/base/curd';
        jump_url = SCOPE.jump_url;
        $.post(url, postData, function (result) {
            if (result.status === 1) {
                //成功
                return dialog.successon(result.message,jump_url);
            } else if (result.status === 0) {
                // 失败
                return dialog.error(result.message,jump_url);
            }
        }, "JSON");
    });


});

/*假性删除*/
function CmsDelete(obj) {
    var id = $(obj).attr('attr-id'),
        data = {id:id,table:SCOPE.model,methodType:'delete'};
    layer.confirm('确认要删除吗？', function (index) {
        $.post('/admin/base/curd', data, function (result) {
            if (result.status === 1) {
                layer.msg('已删除!', {icon: 1, time: 1000});
                $(obj).parents("tr").remove();
                // window.location.reload();
            } else if (result.status === 0) {
                // 失败
                return dialog.error(result.message);
            }
        }, "JSON");
    });
}

/*真删除*/
function realDelete(obj) {
    var id = $(obj).attr('attr-id'),
        data = {id:id,table:SCOPE.model,methodType:'realDelete'};
    console.log(data);
    layer.confirm('确认要删除吗？', function (index) {
        $.post('/admin/base/curd', data, function (result) {
            if (result.status === 1) {
                layer.msg('已删除!', {icon: 1, time: 1000});
                $(obj).parents("tr").remove();
                // window.location.reload();
            } else if (result.status === 0) {
                // 失败
                return dialog.error(result.message);
            }
        }, "JSON");
    });
}


function layer_edit(title,url,obj,w,h){
    var id=$(obj).attr('attr-id');
    var urls = SCOPE.edit_url+id;
    if (title == null || title == '') {
        title=false;
    };
    if (w == null || w == '') {
        w=($(window).width()*0.9);
    };
    if (h == null || h == '') {
        h=($(window).height() - 50);
    };
    layer.open({
        type: 2,
        area: [w+'px', h +'px'],
        fix: false, //不固定
        maxmin: true,
        shadeClose: true,
        shade:0.4,
        title: title,
        content: urls,
        /*        end: function () {
                    alert('123');
                }*/
    });
}







