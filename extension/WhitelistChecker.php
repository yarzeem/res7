<?php declare(strict_types=1);
namespace res7\extension;

use res7\contract\Checkable as Checkable;
use res7\core\Request as Request;
use res7\utils\ServerUtils as ServerUtils;
use res7\core\Configuration as Configuration;
use res7\core\Logger as Logger;

class WhitelistChecker implements Checkable {

    public function check(Request $request) : bool {
        $remoteAddres = ServerUtils::getClientIpAddress();
        $config = Configuration::get();
        foreach ($config['whitelist-checker']['clients'] as $whiteIp) {
            if ($remoteAddres === $whiteIp) {
                return true;
            }
        }
        Logger::res7("Request from ip [$remoteAddres] not found on clients whitelist!");
        return false;
    }

}
?>
