<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info(Request $request, $id = 0)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(401, '您无权访问该应用');
        }

        $me = [
            'id'   => $id,
            'name' => 'ansme',
            'age'  => '24',
            'sex'  => '男'
        ];

        $data = [
            'code' => self::CODE_OK,
            'msg'  => 'ok',
            'user' => $me
        ];
        return $this->response($data);
    }

    public function modify(Request $request, $id = 0)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(401, '您无权访问该应用');
        }

        $form = $request->all();
        return $this->response($form);
    }
}
