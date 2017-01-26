<?php declare(strict_types=1);
namespace res7\core;

use res7\contract\Checkable as Checkable;

class ExtensionsProvider {

    protected static $checkables = [];
    protected static $initialized = false;

    protected static function getExtensionFiles() {
        return glob("../res7/extension/" . "*.php");
    }

    protected static function initialize() {
        foreach (self::getExtensionFiles() as $file) {
            include_once $file;
            $temp = explode("/", $file);
            $className = substr($temp[count($temp) - 1], 0, -4); // cut extension
            $namespace = str_replace("/", "\\", substr($file, 3, (strlen($className) + 4) * -1));
            $qualifiedClass = $namespace . $className;
            $instance = new $qualifiedClass();
            if ($instance instanceof Checkable) {
                self::$checkables []= $instance;
            }
        }
        self::$initialized = true;
    }

    public static function getCheckableExtensions() {
        if (self::$initialized === false) {
            self::initialize();
        }
        return self::$checkables;
    }

}
