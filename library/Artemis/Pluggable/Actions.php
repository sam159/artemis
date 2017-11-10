<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 05/12/2016
 * Time: 09:33 PM
 */

namespace Artemis\Pluggable;


class Actions
{
    use CallChainTrait;

    public function RunArray($name, array $params) {
        if (array_key_exists($name, $this->chain)) {
            foreach($this->chain[$name] as $v) {
                list(, $callback) = $v;
                call_user_func_array($callback, $params);
            }
        }
    }

    public function Run($name, ...$params) {
        $this->RunArray($name, $params);
    }

}