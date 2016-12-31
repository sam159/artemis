<?php

/*
 * Procedural interface to Artemis\Pluggable\*
 */

/* Actions */

use Artemis\Pluggable\Actions;

function actions_add($name, $handle, callable $callback, $priority = 50) {
    Actions::Add($name, $handle, $callback, $priority);
}
function actions_remove($name, $handle) {
    return Actions::Remove($name, $handle);
}
function actions_run($name, ...$params) {
    Actions::RunArray($name, $params);
}

/* Filters */

use Artemis\Pluggable\Filters;

function filters_add($name, $handle, callable $callback, $priority = 50) {
    Filters::Add($name, $handle, $callback, $priority);
}
function filters_remove($name, $handle) {
    return Filters::Remove($name, $handle);
}
function filters_run($name, $value, ...$params) {
    return Filters::RunArray($name, $value, $params);
}

/* Plugins */

