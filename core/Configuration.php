<?php declare(strict_types=1);
namespace res7\core;

use res7\core\Logger as Logger;

class Configuration {

    private static $instance;
    protected $content;

    private function __construct(String $iniPath) {
        $this -> content = parse_ini_file($iniPath, true);
    }

    public static function initialize($iniPath) {
        if (self::$instance === null) {
            self::$instance = new Configuration($iniPath);
            Logger::initialize();
        } else {
            throw new \BadFunctionCallException("Configuration already initialized.");
        }
    }

    public static function get() {
        return self::$instance -> content;
    }

}

?>
