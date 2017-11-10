<?php

//Default locations

if (!defined('ARTE_ROOT_DIR')) {
    define('ARTE_ROOT_DIR', pathjoin(__DIR__, '..'));
}

if (!defined('ARTE_CONTENT_DIR')) {
    define('ARTE_CONFIG_DIR', pathjoin(ARTE_ROOT_DIR, 'config'));
}

if (!defined('ARTE_CONTENT_DIR')) {
    define('ARTE_CONTENT_DIR', pathjoin(ARTE_ROOT_DIR, 'content'));
}

if (!defined('ARTE_CACHE_DIR')) {
    define('ARTE_CACHE_DIR', pathjoin(ARTE_CONTENT_DIR, 'cache'));
}
if (!defined('ARTE_PLUGIN_DIR')) {
    define('ARTE_PLUGIN_DIR', pathjoin(ARTE_CONTENT_DIR, 'plugins'));
}
if (!defined('ARTE_THEME_DIR')) {
    define('ARTE_THEME_DIR', pathjoin(ARTE_CONTENT_DIR, 'themes'));
}
if (!defined('ARTE_UPLOADS_DIR')) {
    define('ARTE_UPLOADS_DIR', pathjoin(ARTE_CONTENT_DIR, 'uploads'));
}