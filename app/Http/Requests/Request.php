<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class Request extends FormRequest
{

    protected function formatErrors(Validator $validator)
    {

        return array('status'=>422, 'msg'=>implode(',', $validator->errors()->all()));
//        return $validator->errors()->all();
    }

    protected function failedValidation(Validator $validator)
    {
        // 此处自定义您想要返回的数据类型
        $data = [
            'code' => 400,
            'msg' => $validator->errors()->first(),
        ];
        $respone = new Response(json_encode($data));
        throw (new ValidationException($validator, $respone))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

}
