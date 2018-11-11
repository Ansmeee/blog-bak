<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const CODE_OK = 200;
    const CODE_REQUEST_ERR = 400;
    const CODE_UNAUTHORIZED = 401;
    const CODE_NOT_FOUND = 404;
    const CODE_SERVER_ERR = 500;

    protected function authorized()
    {
        $token = $_SERVER['HTTP_X_AUTH_TOKEN'];
        if (!$token) return false;

        $authToken = env('AUTH_TOKEN');
        if ($authToken == $token) return true;

        return false;
    }

    protected function response($data = [], $code = 200, $msg = '')
    {
        $response = [
            'code' => $code,
            'msg'  => $msg
        ];

        if (!empty($data)) {
            $response = array_merge($response, $data);
        }

        return response()->json($response);
    }

    protected function responseErr($code = 400, $msg = '')
    {
        $response = [
            'code' => $code,
            'msg'  => $msg
        ];

        return response()->json($response);
    }
}
