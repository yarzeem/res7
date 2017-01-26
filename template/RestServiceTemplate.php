<?php declare(strict_types=1);
namespace {{namespace}};

use res7\core\RestService as RestService;
use res7\core\Request as Request;

/**
 * Implementation of res7\core\RestService abstract class, used
 * by res7\core\ServiceDispatcher serve clients request. Before
 * implementing PATCH, PUT and DELETE methods check your http
 * server configuration - there is a high probability that they
 * are disabled by default.
 * This class was generated with usage of res7 scripts.
 */
class {{serviceName}} extends RestService {

    /**
     * Implementation required for RestService inheritance
     * Implement GET request method logic inside.
     * If not required, send HttpResponseCode::METHOD_NOT_ALLOWED
     * status with termination flage set as true by ServerUtils
     * utility class, or specify property "disallow" on service
     * object in JSON configuration file used to generate this
     * class, and regenerate it.
     * @param $request Instance of res7\core\Request class, which
     * is a unified representation of all possible http request
     * methods. Use it to get request parameters, or important
     * information about clients request.
     */
    protected function doGet(Request $request) {{{GET}}}

    /**
     * Implementation required for RestService inheritance
     * Implement POST request method logic inside.
     * If not required, send HttpResponseCode::METHOD_NOT_ALLOWED
     * status with termination flage set as true by ServerUtils
     * utility class, or specify property "disallow" on service
     * object in JSON configuration file used to generate this
     * class, and regenerate it.
     * @param $request Instance of res7\core\Request class, which
     * is a unified representation of all possible http request
     * methods. Use it to get request parameters, or important
     * information about clients request.
     */
    protected function doPost(Request $request) {{{POST}}}

    /**
     * Implementation required for RestService inheritance
     * Implement PUT request method logic inside.
     * If not required, send HttpResponseCode::METHOD_NOT_ALLOWED
     * status with termination flage set as true by ServerUtils
     * utility class, or specify property "disallow" on service
     * object in JSON configuration file used to generate this
     * class, and regenerate it.
     * @param $request Instance of res7\core\Request class, which
     * is a unified representation of all possible http request
     * methods. Use it to get request parameters, or important
     * information about clients request.
     */
    protected function doPut(Request $request) {{{PUT}}}

    /**
     * Implementation required for RestService inheritance
     * Implement PATCH request method logic inside.
     * If not required, send HttpResponseCode::METHOD_NOT_ALLOWED
     * status with termination flage set as true by ServerUtils
     * utility class, or specify property "disallow" on service
     * object in JSON configuration file used to generate this
     * class, and regenerate it.
     * @param $request Instance of res7\core\Request class, which
     * is a unified representation of all possible http request
     * methods. Use it to get request parameters, or important
     * information about clients request.
     */
    protected function doPatch(Request $request) {{{PATCH}}}

    /**
     * Implementation required for RestService inheritance
     * Implement DELETE request method logic inside.
     * If not required, send HttpResponseCode::METHOD_NOT_ALLOWED
     * status with termination flage set as true by ServerUtils
     * utility class, or specify property "disallow" on service
     * object in JSON configuration file used to generate this
     * class, and regenerate it.
     * @param $request Instance of res7\core\Request class, which
     * is a unified representation of all possible http request
     * methods. Use it to get request parameters, or important
     * information about clients request.
     */
    protected function doDelete(Request $request) {{{DELETE}}}

}

?>
