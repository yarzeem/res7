<?php
spl_autoload_register(function ($className) {
    if (0 === strpos($className, 'res7')) {
        $temp = explode("\\", $className);
        $class = $temp[count($temp) - 1];
        $dir = str_replace("\\", "/" ,substr($className, 0, strlen($class) * -1));
        require_once "../" . $dir . $class . ".php";
    }
});
use res7\core\Configuration as Configuration;
use res7\core\ServiceDispatcher as ServiceDispatcher;
Configuration::initialize("res7.ini");
$config = Configuration::get();
(new ServiceDispatcher($config['res7']['services-dir'], $config['res7']['services-namespace'])) -> run();
?>
