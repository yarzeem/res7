<?php declare(strict_types=1);
namespace res7\core;

use res7\enum\HttpRequestMethod as HttpRequestMethod;
use res7\utils\ServerUtils as ServerUtils;
use res7\core\Request as Request;
use res7\core\Logger as Logger;

class Request {

    public $method;
    public $parameters;

    public function __construct() {
        $this -> method = ServerUtils::getRequestMethod();
        $this -> parseParameters();
        Logger::res7("Received request with method [$this->method]");
    }

    protected function parseParameters() {
        switch ($this -> method) {
            case HttpRequestMethod::PATCH :
            case HttpRequestMethod::PUT :
            case HttpRequestMethod::DELETE :
                parse_str(file_get_contents('php://input'), $this -> parameters); break;
            case HttpRequestMethod::GET :
                $this -> parameters = $_GET; break;
            case HttpRequestMethod::GET :
                $this -> parameters = $_POST; break;
        }
    }

}

?>
