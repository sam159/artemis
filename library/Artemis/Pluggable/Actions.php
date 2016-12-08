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

    public static function Add($name, $handle, callable $callback, $priority = 50) {
        if (array_key_exists($name, self::$actions)) {
            //Find position to add, before any higher priority
            for($i=0; $i < count(self::$actions[$name]); $i++) {
                if (self::$actions[$name][$i][2] > $priority) {
                    break;
                }
            }
            array_splice(self::$actions[$name], $i, 0, [[$handle, $callback, $priority]]);
        } else {
            self::$actions[$name] = [[$handle, $callback, $priority]];
        }
    }

    public static function Remove($name, $handle) {
        if (!array_key_exists($name, self::$actions)) {
            return false;
        }
        $pos = -1;
        foreach(self::$actions[$name] as $i => $v) {
            list($h,) = $v;
            if ($h == $handle) {
                $pos = $i;
                break;
            }
        }
        if ($pos > -1) {
            array_splice(self::$actions[$name], $pos, 1);
            return true;
        }
        return false;
    }

    public static function RunArray($name, array $params) {
        if (array_key_exists($name, self::$actions)) {
            foreach(self::$actions[$name] as $v) {
                list(, $callback) = $v;
                call_user_func_array($callback, $params);
            }
        }
    }

    public static function Run($name, ...$params) {
        self::RunArray($name, $params);
    }

}