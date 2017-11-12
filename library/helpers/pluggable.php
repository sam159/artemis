<?php

/*
 * Procedural interface to Artemis\Pluggable\*
 */

use Artemis\Arte;

/* Actions */

function actions_add($name, $handle, callable $callback, $priority = 50) {
    Arte::$actions->Add($name, $handle, $callback, $priority);
}
function actions_remove($name, $handle) {
    return Arte::$actions->Remove($name, $handle);
}
function actions_run($name, ...$params) {
    Arte::$actions->RunArray($name, $params);
}

/* Filters */

function filters_add($name, $handle, callable $callback, $priority = 50) {
    Arte::$filters->Add($name, $handle, $callback, $priority);
}
function filters_remove($name, $handle) {
    return Arte::$filters->Remove($name, $handle);
}
function filters_run($name, $value, ...$params) {
    return Arte::$filters->RunArray($name, $value, $params);
}

/* Plugins */

/**
 * @param $name
 * @return bool
 */
function plugin_enabled($name) {
    return Arte::$plugins->isEnabled($name);
}

/* Themes */

/**
 * @return \Artemis\Pluggable\Theme\Theme
 */
function theme_get_current() {
    return Arte::$themes->getCurrentTheme();
}