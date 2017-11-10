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

    public function RunArray($name, $value, array $params)
    {
        if (array_key_exists($name, $this->chain)) {
            array_unshift($params, $value);
            foreach ($this->chain[$name] as $v) {
                list(, $callback) = $v;
                $value = call_user_func_array($callback, $params);
            }
        }
        return $value;
    }

    public function Run($name, $value, ...$params)
    {
        return $this->RunArray($name, $value, $params);
    }
}