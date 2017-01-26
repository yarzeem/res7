<?php declare(strict_types=1);
namespace res7\core;

use res7\core\Configuration as Configuration;
use res7\enum\LoggingLevel as LoggingLevel;

class Logger {

    protected static $outputFile;
    protected static $format;
    protected static $datetimeFormat;
    protected static $ignored = [];

    public static function initialize() {
        $config = Configuration::get();
        self::$outputFile = $config['logging']['output-file'];
        self::$format = $config['logging']['format'];
        self::$datetimeFormat = $config['logging']['datetime-format'];
        self::$ignored = $config['logging']['ignore'];
    }

    protected static function formatLog(String $level, String $message) : String {
        $log = self::$format;
        if (strpos($log, '{{datetime}}') !== false) {
            $log = str_replace("{{datetime}}", date(self::$datetimeFormat), $log);
        }
        if (strpos($log, '{{level}}') !== false) {
            $log = str_replace("{{level}}", $level, $log);
        }
        if (strpos($log, '{{backtrace}}') !== false) {
            $backtrace = debug_backtrace();
            $method = "Unavailable";
            if (count($backtrace) > 3) {
                $method = $backtrace[3]['class'] . $backtrace[3]['type'] . $backtrace[3]['function'];
            }
            $log = str_replace("{{backtrace}}", $method, $log);
        }
        if (strpos($log, '{{message}}') !== false) {
            $log = str_replace("{{message}}", $message, $log);
        }
        return $log . "\n";
    }

    protected static function log(String $level, String $message) {
        error_log(self::formatLog($level, $message), 3, self::$outputFile);
    }

    protected static function isIgnored(String $level) : bool {
        foreach (self::$ignored as $key => $value) {
            if ($value === $level) {
                return true;
            }
        }
        return false;
    }

    public static function res7(String $message) {
        if (!self::isIgnored(LoggingLevel::RES7)) {
            self::log(LoggingLevel::RES7, $message);
        }
    }

    public static function debug(String $message) {
        if (!self::isIgnored(LoggingLevel::DEBUG)) {
            self::log(LoggingLevel::DEBUG, $message);
        }
    }

    public static function trace(String $message) {
        if (!self::isIgnored(LoggingLevel::TRACE)) {
            self::log(LoggingLevel::TRACE, $message);
        }
    }

    public static function info(String $message) {
        if (!self::isIgnored(LoggingLevel::INFO)) {
            self::log(LoggingLevel::INFO, $message);
        }
    }

    public static function error(String $message) {
        if (!self::isIgnored(LoggingLevel::ERROR)) {
            self::log(LoggingLevel::ERROR, $message);
        }
    }

    public static function fatal(String $message) {
        if (!self::isIgnored(LoggingLevel::FATAL)) {
            self::log(LoggingLevel::FATAL, $message);
        }
    }

}

?>
