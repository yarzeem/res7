<?php declare(strict_types=1);
namespace res7\utils;

class ServerUtils {

    static function sendStatus(int $statusCode, bool $terminate) {
        http_response_code($statusCode);
        if ($terminate) {
            die();
        }
    }

    static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    // http://stackoverflow.com/questions/13646690/how-to-get-real-ip-from-visitor
    static function getClientIpAddress() {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client; }
        elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward; }
        else {
            $ip = $remote;
        }
        return $ip;
    }

}

?>
