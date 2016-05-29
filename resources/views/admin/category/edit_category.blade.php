@extends('admin.public.master')



@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <form method="" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">上级分类</label>

                        <div class="col-sm-2">
                            <select class="form-control parent_id" name="parent_id">
                                <option value="0">--顶层分类--</option>
                                {!! $categoryOptions !!}
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">分类名称</label>
                        <div class="col-sm-3">
                            <input type="text" name="name" placeholder="分类名称" value="{{$data['name'] or ''}}" class="form-control name">
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">启用</label>
                        <div class="col-sm-3">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="checkbox status" @if($id==0 || $data['status']==1) checked @endif name="status">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">关键字</label>
                        <div class="col-sm-8">
                            <input type="text" placeholder="关键字" class="form-control keywords" name="keywords" value="{{$data['keywords'] or ''}}">
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">描述</label>

                        <div class="col-sm-10">
                            <textarea class="form-control description" placeholder="描述" rows="3" name="description">{{$data['description'] or ''}}</textarea>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">缩略图</label>

                        <div class="col-sm-4 thumb-input-box" @if($data && $data['thumb'])style="display:none"@endif>
                            <input type="file" name="file" id="file" class="form-control file" onchange="uploadImg()">
                        </div>
                        <div class="col-sm-8 thumb-box" @if(!$data || !$data['thumb'])style="display:none"@endif >
                            <div class="col-sm-8">
                                <div style="width: 220px;float: left">
                                    <img src="{{isset($data['thumb']) ? asset($data['thumb']) : ''}}" width="200" />
                                </div>

                                <input type="hidden" value="{{$data['thumb'] or ''}}" name="thumb" class="thumb" />
                                <div style="width: 100px;float: left">
                                    <button type="button" class="btn btn-sm btn-danger delete-thumb">删除图片</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <input type="hidden" class="_token" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" class="id" name="id" value="{{$id}}">
                            <button class="btn btn-white" type="button" onclick="history.go(-1)">取消</button>
                            <button class="btn btn-primary save" type="button">保 存</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent

    <script src="{{asset('static/js/ajaxfileupload.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $('.save').click(function(){
                save();
            });

            $('.delete-thumb').click(function(){
                deleteThumb();
            })
        })

        function save(){
            $('.save').text('保存中...').attr('disabled', true);
            var parent_id = parseInt($('.parent_id').val());
            var id = parseInt($('.id').val());
            var name = $.trim($('.name').val());
            var keywords = $.trim($('.keywords').val());
            var description = $.trim($('.description').val());
            var _token = $.trim($('._token').val());
            var thumb = $.trim($('.thumb').val());

            if(!name){
                swal({title:"保存失败",text:"分类名称不能为空", 'type':'error'});
                $('.save').text('保 存').attr('disabled', false);
                return false;
            }

            var status = 0;
            if($('.status').is(':checked')){
                status = 1;
            }

           /* if(!thumb){
                swal({title:"保存失败",text:"请上传分类缩略图", 'type':'error'});
                $('.save').text('保 存').attr('disabled', false);
                return false;
            }*/

            var data = {parent_id:parent_id, name:name, keywords:keywords, description:description, _token:_token, status:status, id:id, thumb:thumb};
            var url = "{{url('admin/category/store')}}";

            $.ajax({
                type:'POST',
                dataType:'JSON',
                url:url,
                data:data,
                success:function(response){
                    if(response.status==0){
                        window.location.href = "{{url('admin/category')}}";
                    }else{
                        swal({title:"保存失败",text:response.msg, 'type':'error'});
                        $('.save').text('保 存').attr('disabled', false);
                        return false;
                    }
                }
            });
        }

        //上传图片
        function uploadImg(){
            var url = "{{url('upload/thumb')}}";
            $.ajaxFileUpload({
                url:url,
                secureuri:false,
                fileElementId:"file",        //file的id
                dataType:"json",                  //返回数据类型为文本
                success:function(response){
                    if(response.status==0){
                        var url = response.data.url;
                        $('.thumb').val(url);
                        $('.thumb-box').show().find('img').attr('src', url);
                        $('.thumb-input-box').hide();
                    }else{
                        swal({title:"文件上传失败",text:response.msg, 'type':'error'});
                    }
                }
            })
        }

        //删除图片
        function deleteThumb(){
            $('.thumb-input-box').show();
            $('.thumb-box').hide().find('.thumb').val('').siblings('img').attr('src', '');
        }

    </script>


@endsection
