<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function info(Request $request, $id = 0)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(self::CODE_UNAUTHORIZED, '无权访问!');
        }

        $db = DB::connection();
        $sql = "select * from `user` where id = :id";
        $user = $db->selectOne($sql, [':id' => $id]);

        if (!$user) return $this->responseErr(self::CODE_NOT_FOUND, '该用户不存在!');

        $me = [
            'id'   => $user->id,
            'name' => $user->name,
            'sex'  => \App\User::$sexTitle[$user->sex]
        ];

        return $this->response($me);
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
