<?php declare(strict_types=1);
namespace res7\contract;

use res7\core\Request as Request;

interface Checkable {
    public function check(Request $request) : bool;
}

?>
