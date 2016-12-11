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

    public static function RunArray($name, array $params) {
        if (array_key_exists($name, self::$chain)) {
            foreach(self::$chain[$name] as $v) {
                list(, $callback) = $v;
                call_user_func_array($callback, $params);
            }
        }
    }

    public static function Run($name, ...$params) {
        self::RunArray($name, $params);
    }

}