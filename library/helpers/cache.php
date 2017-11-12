<?php

use Symfony\Component\Cache\Simple\AbstractCache;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * @param string $namespace
 * @return AbstractCache
 */
function cachestore_get($namespace) {
    static $stores = [];
    if (array_key_exists($namespace, $stores)) {
        return $stores[$namespace];
    }

    $cache = filters_run('cachestore::get', null, $namespace);
    if ($cache != null && $cache instanceof AbstractCache) {
        return $stores[$namespace] = $cache;
    }

    if (!file_exists(pathjoin(ARTE_CACHE_DIR, 'arte'))) {
        @mkdir(pathjoin(ARTE_CACHE_DIR, 'arte'), 0755, true);
    }
    return $stores[$namespace] = new FilesystemCache('arte', 0, ARTE_CACHE_DIR);
}

/**
 * Gets a value from the default cache store
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function cache_get($key, $default = null) {
   return \Artemis\Arte::$cache->get($key, $default);
}

/**
 * Sets a value in the default cache store.
 * A value of `null` will remove the item.
 *
 * @param string $key
 * @param mixed $value
 * @param int|null $ttl
 */
function cache_set($key, $value ,$ttl = null) {
    $cache = \Artemis\Arte::$cache;
    if ($value === null) {
        $cache->delete($key);
    } else {
        $cache->set($key, $value, $ttl);
    }
}

/**
 * Checks the default cache store for the given key
 *
 * @param string $key
 * @return bool
 */
function cache_has($key) {
    return \Artemis\Arte::$cache->has($key);
}