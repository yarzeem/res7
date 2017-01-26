<?php declare(strict_types=1);
namespace res7\core;

use res7\enum\HttpResponseCode as HttpResponseCode;
use res7\enum\HttpRequestMethod as HttpRequestMethod;
use res7\core\ExtensionsProvider as ExtensionsProvider;
use res7\utils\ServerUtils as ServerUtils;
use res7\core\Request as Request;
use res7\core\Logger as Logger;

abstract class RestService {

    // Termination cases
    const TERMINATE = true;
    const DO_NOT_TERMINATE = false;

    protected $response = [];

    protected function check(Request $request) {
        Logger::res7("Checking request object with all Checkable extensions...");
        $extensions = ExtensionsProvider::getCheckableExtensions();
        foreach ($extensions as $extension) {
            if (!($extension -> check($request))) {
                Logger::res7("Request not passed the check of [$extension]. Terminating request.");
                ServerUtils::sendStatus(HttpResponseCode::FORBIDDEN, self::TERMINATE);
            }
        }
        Logger::res7("... looking good, allowing execution.");
    }

    protected function do(Request $request) {
        switch ($request -> method) {
            case HttpRequestMethod::GET:     $this -> doGet($request);    break;
            case HttpRequestMethod::POST:    $this -> doPost($request);   break;
            case HttpRequestMethod::PUT:     $this -> doPut($request);    break;
            case HttpRequestMethod::PATCH:   $this -> doPatch($request);  break;
            case HttpRequestMethod::DELETE:  $this -> doDelete($request); break;
            default: ServerUtils::sendStatus(HttpResponseCode::NOT_FOUND, self::TERMINATE);
        }
        ServerUtils::sendStatus(HttpResponseCode::OK, self::DO_NOT_TERMINATE);
    }

    protected function rest() {
        Logger::res7("Printing response...");
        echo json_encode($this -> response);
    }

    public function invoke(Request $request) {
        $this -> check($request);
        $this -> do($request);
        $this -> rest();
        Logger::res7("Job's Done!");
    }

    abstract protected function doGet(Request $request);
    abstract protected function doPost(Request $request);
    abstract protected function doPut(Request $request);
    abstract protected function doPatch(Request $request);
    abstract protected function doDelete(Request $request);

}

?>
