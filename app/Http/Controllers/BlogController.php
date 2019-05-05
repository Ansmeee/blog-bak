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

        $form = $request->all();
        list($start, $perpage) = $this->pagination($form['start'], $form['perpage']);

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

    public function like(Request $request)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(self::CODE_UNAUTHORIZED, '无权访问!');
        }

        $form   =   $request->all();
        $id     =   $form['id'];
        $blog = \App\Story::find($id);
        if (!$blog) {
            return $this->responseErr(self::CODE_NOT_FOUND, '没有找到!');
        }

        $likeCount = $blog->like;
        $blog->like = $likeCount + 1;
        if (!$blog->save()) {
            return $this->responseErr(self::CODE_SERVER_ERR, '操作失败!');
        }

        return $this->response();
    }

    public function dislike(Request $request)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(self::CODE_UNAUTHORIZED, '无权访问!');
        }

        $form   =   $request->all();
        $id     =   $form['id'];
        $blog = \App\Story::find($id);
        if (!$blog) {
            return $this->responseErr(self::CODE_NOT_FOUND, '没有找到!');
        }

        $dislikeCount = $blog->dislike;
        $blog->dislike = $dislikeCount + 1;
        if (!$blog->save()) {
            return $this->responseErr(self::CODE_SERVER_ERR, '操作失败!');
        }

        return $this->response();
    }
}
