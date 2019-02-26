<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BloggerController extends Controller
{
    public function index(Request $request)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(self::CODE_UNAUTHORIZED, '无权访问!');
        }

        $user = \App\User::where('type', \App\User::BLOGGER)->first();
        if (!$user) return $this->responseErr(self::CODE_NOT_FOUND, '该用户不存在!');

        $blogger = [
            'id'    => $user->id,
            'name'  => $user->name,
            'motto' => $user->motto,
            'hobby' => $user->hobby,
            'trips' => $user->getTrips()
        ];

        return $this->response($blogger);
    }

    public function info(Request $request)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(self::CODE_UNAUTHORIZED, '无权访问!');
        }

        $user = \App\User::where('type', \App\User::BLOGGER)->first();
        if (!$user) return $this->responseErr(self::CODE_NOT_FOUND, '该用户不存在!');

        $data['info'] = [
            'name'  => $user->name,
            'icon'  => $user->icon,
            'myHost'  => '',
            'blogs' => $user->getBlogSummary(),
            'menus'   => $this->_getMenus()
        ];

        return $this->response($data);
    }

    private function _getMenus()
    {
        $menus = [
            [
                'title' =>  '首页',
                'url'   =>  'home',
                'icon'  =>  'el-icon-menu'
            ],
            [
                'title' =>  '分类',
                'url'   =>  'class',
                'icon'  =>  'el-icon-document'
            ]
        ];

        return $menus;
    }

}
