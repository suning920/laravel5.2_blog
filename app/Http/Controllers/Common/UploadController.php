<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function thumb(Request $request)
    {
        return $this->upload('thumb', $request);
    }

    public function banner(Request $request)
    {
        return $this->upload('banner', $request);
    }

    public function image(Request $request)
    {
        return $this->upload('image', $request);
    }

    /**
     * @param $type  图片类型
     * @param $request
     * @return string
     */
    public function upload($type, $request)
    {
        if (!$request->hasFile('file')) {
            return ajaxResponse(1, trans('upload_file.un_get_upload_file'));
        }

        if(!$request->file('file')->isValid()){
            return ajaxResponse(1, trans('upload_file.uploading_file_error'));
        }

        switch ($type){
            case 'thumb':
                $path = config('web.thumb_image_path');
                break;
            case 'banner':
                $path = config('web.banner_image_path');
                break;
            case 'image':
                $path = config('web.upload_image_path');
                break;
        }

        $file = $request->file('file');

        $extension = $request->file('file')->getClientOriginalExtension();

        $filename = md5(date('YmdHis').$type.rand(10000,99999)).'.'.$extension;
        $destinationPath = $path.date('Ymd').'/';

        if(!is_dir($destinationPath)){
            mkdir($destinationPath);
        }

        $res = $file->move($destinationPath, $filename);
        if($res){
            $url = url('/').'/'.$destinationPath.$filename;
            return json_encode(array('status'=>0, 'msg'=>'success', 'data'=>array('url'=>$url)));
        }else{
            return json_encode(array('status'=>1, 'msg'=>trans('upload_file.upload_file_fail')));
        }
    }

    public function markdown(Request $request)
    {
        $name = 'editormd-image-file';
        if (!$request->hasFile($name)) {
            //return ajaxResponse(0, trans('upload_file.un_get_upload_file'));
            return json_encode(array('success'=>0, 'msg'=>trans('upload_file.un_get_upload_file')));
        }

        if(!$request->file($name)->isValid()){
            //return ajaxResponse(0, trans('upload_file.uploading_file_error'));
            return json_encode(array('success'=>0, 'msg'=>trans('upload_file.uploading_file_error')));
        }

        $path = config('web.upload_image_path');

        $file = $request->file($name);

        $extension = $request->file($name)->getClientOriginalExtension();

        $filename = md5(date('YmdHis').'image'.rand(10000,99999)).'.'.$extension;
        $destinationPath = $path.date('Ymd').'/';

        if(!is_dir($destinationPath)){
            mkdir($destinationPath);
        }

        $res = $file->move($destinationPath, $filename);
        if($res){
            $url = url('/').'/'.$destinationPath.$filename;
            return json_encode(array('success'=>1, 'msg'=>'success', 'url'=>$url));
        }else{
            return json_encode(array('success'=>0, 'msg'=>trans('upload_file.upload_file_fail')));
        }
    }
}
