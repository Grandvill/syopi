<?php

namespace App;

class ResponseFormatter
{
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => [],
            'validation' => null,
            'response_data' => null,
        ],
        'data' => null
    ];

    public static function success($data = null, $messages = [])
    {
        $response['meta']['code'] = 200;
        $response['meta']['status'] = 'success';
        $response['meta']['message'] = $message;
        $response['data'] = $data;
        return $response;
    }

    public static function error($code = null, $validation = null, $messages = [])
    {
        $response['meta']['status'] = 'error';
        $response['meta']['code'] = $code;
        $response['meta']['messages'] = $messages;
        $response['meta']['validation'] = $validation;
        $response['meta']['response_data'] = now()->format('Y-m-d H:i:s');

        return response()->json(self::$response, $self::$response['meta']['code']);
    }
}