<?php

/**
 * @param string $name
 * @return array|null
 */
function config_get($name) {
    $c = \Artemis\Arte::$config->get($name);
    if (is_array($c)) {
        return $c;
    }
    return null;
}

function config_get_item($name, $item, $default = null) {
    $c = config_get($name);
    if (is_array($c)) {
        if (array_key_exists($item, $c)) {
            return $c[$item];
        }
    }
    return $default;
}