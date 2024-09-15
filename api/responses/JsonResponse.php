<?php
// api/responses/JsonResponse.php

class JsonResponse {
    public static function success($data, $status = 200) {
        http_response_code($status);
        echo json_encode(['status' => 'success', 'data' => $data]);
    }

    public static function error($message, $status = 400) {
        http_response_code($status);
        echo json_encode(['status' => 'error', 'message' => $message]);
    }
}
