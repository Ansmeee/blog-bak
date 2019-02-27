<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(self::CODE_UNAUTHORIZED, '无权访问!');
        }

        $form   =   $request->all();
        $id     =   $form['id'];

        $blog   =   \App\Story::find($id);
        if (!$blog) {
            return $this->responseErr(self::CODE_NOT_FOUND, '没有找到!');
        }

        $data['blog']   = [
            'id'        =>  $blog->id,
            'title'     =>  $blog->title,
            'date'      =>  $blog->date,
            'type'      =>  $blog->label,
            'content'   =>  $blog->content
        ];
        return $this->response($data);
    }

    public function list(Request $request)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(self::CODE_UNAUTHORIZED, '无权访问!');
        }

        $form       =   $request->all();
        $perpage    =   $form['perpage'] ? (int)$form['perpage'] : 10;
        $start      =   ((int)$form['start'] - 1) > 0 ? ((int)$form['start'] - 1) * $perpage : 0;

        $blogsCount = \App\Story::where('type', \App\Story::Blog)->count();

        $content['total'] = $blogsCount;
        $content['list']  = [];
        if ($blogsCount) {
            $blogs = \App\Story::where('type', \App\Story::Blog)->paginate($perpage, null, null, $start);
            foreach ($blogs as $blog) {
                $content['list'][] = [
                    'id'        =>  $blog->id,
                    'title'     =>  $blog->title,
                    'type'      =>  $blog->type,
                    'date'      =>  $blog->date,
                    'summary'    =>  $blog->summary
                ];
            }
        }

        $data['content'] = $content;
        return $this->response($data);
    }
}
