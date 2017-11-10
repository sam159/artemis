<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 11/12/2016
 * Time: 01:33 PM
 */

namespace Artemis\Pluggable;


trait CallChainTrait
{
    protected $chain = [];

    public function Add($name, $handle, callable $callback, $priority = 50) {
        if (array_key_exists($name, $this->chain)) {
            //Find position to add, before any higher priority
            for($i=0; $i < count($this->chain[$name]); $i++) {
                if ($this->chain[$name][$i][2] > $priority) {
                    break;
                }
            }
            array_splice($this->chain[$name], $i, 0, [[$handle, $callback, $priority]]);
        } else {
            $this->chain[$name] = [[$handle, $callback, $priority]];
        }
    }

    public function Remove($name, $handle) {
        if (!array_key_exists($name, $this->chain)) {
            return false;
        }
        $pos = -1;
        foreach($this->chain[$name] as $i => $v) {
            list($h,) = $v;
            if ($h == $handle) {
                $pos = $i;
                break;
            }
        }
        if ($pos > -1) {
            array_splice($this->chain[$name], $pos, 1);
            return true;
        }
        return false;
    }

}