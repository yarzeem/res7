<?php declare(strict_types=1);
namespace res7\core;

use res7\core\RestService as RestService;
use res7\core\ExtensionsProvider as ExtensionsProvider;
use res7\core\Request as Request;
use res7\utils\ServerUtils as ServerUtils;
use res7\enum\HttpResponseCode as HttpResponseCode;
use res7\enum\HttpRequestMethod as HttpRequestMethod;
use res7\core\Logger as Logger;

class ServiceDispatcher {

    protected $dir;
    protected $namespace;
    protected $request;

    public function __construct(string $dir, string $namespace) {
        $this -> dir = $dir;
        $this -> namespace = $namespace;
        $this -> request = new Request();
        Logger::res7("ServiceDispatcher instance created");
    }

    protected function isDispatchRewrited() {
        return isset($this -> request -> parameters["__dispatch"]);
    }

    protected function getRewritedDispatch() {
        return $this -> request -> parameters["__dispatch"];
    }

    protected function doesServiceExists($dispatch) {
        return file_exists($this -> dir . $dispatch . ".php");
    }

    protected function getService($dispatch) : RestService {
        include_once $this -> dir . $dispatch . ".php";
        $qualifiedServiceName = $this -> namespace . $dispatch;
        return new $qualifiedServiceName();
    }

    public function run() {
        if ($this -> isDispatchRewrited()) {
            $dispatch = $this -> getRewritedDispatch();
            if (!($this -> doesServiceExists($dispatch))) {
                Logger::res7("Dispatcher received valid request, but demanded service do not exist in service-dir");
                ServerUtils::sendStatus(HttpResponseCode::NOT_FOUND, true);
            }
            Logger::res7("Dispatcher received valid request, dispatching to [${dispatch}]");
            ($this -> getService($dispatch)) -> invoke($this -> request);
        } else {
            Logger::res7("Dispatcher received invalid request. Refusing to collaborate.");
            ServerUtils::sendStatus(HttpResponseCode::BAD_REQUEST, true);
        }
    }

}
