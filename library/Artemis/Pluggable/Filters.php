<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 05/12/2016
 * Time: 09:36 PM
 */

namespace Artemis\Pluggable;


class Filters
{
    use CallChainTrait;

    public static function RunArray($name, $value, array $params)
    {
        if (array_key_exists($name, self::$chain)) {
            array_unshift($params, $value);
            foreach (self::$chain[$name] as $v) {
                list(, $callback) = $v;
                $value = call_user_func_array($callback, $params);
            }
        }
        return $value;
    }

    public static function Run($name, $value, ...$params)
    {
        return self::RunArray($name, $value, $params);
    }
}