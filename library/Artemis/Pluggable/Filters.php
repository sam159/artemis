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

    public static function Add($name, $handle, callable $callback) {
        if (array_key_exists($name, self::$filters)) {
            array_push(self::$filters[$name], [$handle, $callback]);
        } else {
            self::$filters[$name] = [[$handle, $callback]];
        }
    }

    public static function Remove($name, $handle) {
        if (!array_key_exists($name, self::$filters)) {
            return false;
        }
        $pos = -1;
        foreach(self::$filters[$name] as $i => $v) {
            list($h, ) = $v;
            if ($h == $handle) {
                $pos = $i;
                break;
            }
        }
        if ($pos > -1) {
            array_splice(self::$filters[$name], $pos, 1);
            return true;
        }
        return false;
    }

    public static function RunArray($name, $value, array $params) {
        if (array_key_exists($name, self::$filters)) {
            array_unshift($params, $value);
            foreach(self::$filters[$name] as $v) {
                list(, $callback) = $v;
                $value = call_user_func_array($callback, $params);
            }
        }
        return $value;
    }

    public static function Run($name, $value, ...$params) {
        return self::RunArray($name, $value, $params);
    }
}