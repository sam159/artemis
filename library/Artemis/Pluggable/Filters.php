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
    private static $filters = [];

    public static function Add($name, callable $callback) {
        if (array_key_exists($name, self::$filters)) {
            array_push(self::$filters[$name], $callback);
        } else {
            self::$filters[$name] = [$callback];
        }
    }

    public static function RunArray($name, $value, array $params) {
        if (array_key_exists($name, self::$filters)) {
            array_unshift($params, $value);
            foreach(self::$filters[$name] as $callback) {
                $value = call_user_func_array($callback, $params);
            }
        }
        return $value;
    }

    public static function Run($name, $value, ...$params) {
        return self::RunArray($name, $value, $params);
    }
}