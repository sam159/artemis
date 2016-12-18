<?php

/**
 * File Helpers
 */

/***
 * Joins the given path segments
 */
function pathjoin() {
    $parts = [];
    $ds = DIRECTORY_SEPARATOR;

    foreach(func_get_args() as $arg) {
        if ($arg != '') {
            array_push($parts, $arg);
        }
    }

    $repcount = 0;
    $path = join($ds, $parts);
    do {
        $path = str_replace($ds.$ds, $ds, $path, $repcount);
    } while($repcount > 0);

    return $path;
}