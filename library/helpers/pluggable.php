<?php

/*
 * Procedural interface to Artemis\Pluggable\*
 */

/* Actions */

use Artemis\Pluggable\Actions;

function actions_add($name, callable $callback) {
    Actions::Add($name, $callback);
}
function actions_run($name, ...$params) {
    Actions::RunArray($name, $params);
}

/* Filters */

use Artemis\Pluggable\Filters;

function filters_add($name, callable $callback) {
    Filters::Add($name, $callback);
}

function filters_run($name, $value, ...$params) {
    return Filters::RunArray($name, $value, $params);
}