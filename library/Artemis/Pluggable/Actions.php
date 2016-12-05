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
    private static $actions = [];

    public static function Add($name, callable $callback) {
        if (array_key_exists($name, self::$actions)) {
            array_push(self::$actions[$name], $callback);
        } else {
            self::$actions[$name] = [$callback];
        }
    }

    public static function RunArray($name, array $params) {
        if (array_key_exists($name, self::$actions)) {
            foreach(self::$actions as $callback) {
                call_user_func_array($callback, $params);
            }
        }
    }

    public static function Run($name, ...$params) {
        self::RunArray($name, $params);
    }

}