<?php

namespace App;

class ResponseFormatter
{
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'messages' => [],
            'validation' => null,
            'response_date' => null,
        ],
        'data' => null
    ];

    public static function success($data = null, $messages = [])
    {
        $response = self::$response;

        $response['meta']['code'] = 200;
        $response['meta']['status'] = 'success';
        $response['meta']['messages'] = $messages;
        $response['meta']['response_date'] = now()->format('Y-m-d H:i:s');
        $response['data'] = $data;

        return response()->json($response, 200);
    }

    public static function error($code = null, $validation = null, $messages = [])
    {
        $response = self::$response;

        $response['meta']['status'] = 'error';
        $response['meta']['code'] = $code ?? 400;
        $response['meta']['messages'] = $messages;
        $response['meta']['validation'] = $validation;
        $response['meta']['response_date'] = now()->format('Y-m-d H:i:s');
        $response['data'] = null;

        return response()->json($response, $response['meta']['code']);
    }
}