<?php

namespace Artemis;


use Artemis\Pluggable\Actions;
use Artemis\Pluggable\Filters;
use Artemis\Pluggable\Theme\Manager as ThemeManager;
use Artemis\Pluggable\Plugin\Manager as PluginManager;
use Artemis\Render\Render;
use Symfony\Component\Cache\Simple\AbstractCache;

class Arte
{
    /** @var Actions */
    public static $actions;

    /** @var Filters */
    public static $filters;

    /** @var Render */
    public static $render;

    /** @var PluginManager */
    public static $plugins;

    /** @var ThemeManager */
    public static $themes;

    /** @var Config */
    public static $config;

    /** @var AbstractCache */
    public static $cache;

    public static function Init()
    {
        //Load the easy ones
        self::$actions = new Actions();
        self::$filters = new Filters();
        self::$config = new Config(ARTE_CONFIG_DIR);
        self::$render = new Render();

        //Init plugins + early plugins
        self::LoadPlugins();

        //Load the cache
        self::$cache = cachestore_get('arte');

        //Load enabled plugins
        self::$plugins->enablePlugins(config_get_item('plugins', 'enabled', []));
        self::$plugins->loadEnabled();

        //Load themes
        self::LoadThemes();
    }

    protected static function LoadPlugins()
    {
        //Init Plugins
        self::$plugins = $manager = new Pluggable\Plugin\Manager(
            new Pluggable\Plugin\Scanner(ARTE_PLUGIN_DIR),
            config_get_item('plugins', 'early-enabled', [])
        );
        $manager->initialise();
        $manager->loadEnabled();
    }

    protected static function LoadThemes()
    {
        self::$themes = $manager = new ThemeManager(
            new Pluggable\Theme\Scanner(ARTE_THEME_DIR)
        );
        $manager->initialise(
            config_get_item('theme', 'name', 'default')
        );
    }
}