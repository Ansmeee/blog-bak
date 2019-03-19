<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function list(Request $request)
    {
        // 接口权限验证
        if (!$this->authorized()) {
            return $this->responseErr(self::CODE_UNAUTHORIZED, '无权访问!');
        }

        $form       =   $request->all();
        $perpage    =   $form['perpage'] ? (int)$form['perpage'] : 10;
        $start      =   ((int)$form['start'] - 1) > 0 ? ((int)$form['start'] - 1) * $perpage : 0;
        $keywords   =   $form['keywords'];

        $blogs = \App\Story::where('type', \App\Story::Blog);
        if ($keywords) {
            $blogs = $blogs->where('keywords', 'like', "%$keywords%");
        }

        $blogsCount = $blogs->count();
        $content['total'] = $blogsCount;
        $content['list']  = [];
        if ($blogsCount) {
            $blogs = $blogs->paginate($perpage, null, null, $start);
            foreach ($blogs as $blog) {
                $content['list'][] = [
                    'id'        =>  $blog->id,
                    'title'     =>  $blog->title,
                    'type'      =>  $blog->type,
                    'date'      =>  $blog->date
                ];
            }
        }

        $data['content'] = $content;
        return $this->response($data);
    }
}
