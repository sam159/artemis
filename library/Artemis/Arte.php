<?php

namespace Artemis;


use Artemis\Pluggable\Actions;
use Artemis\Pluggable\Filters;
use Artemis\Render\Render;

class Arte
{
    /** @var Actions */
    public static $actions;

    /** @var Filters */
    public static $filters;

    /** @var Render */
    public static $render;

    /** @var Pluggable\Plugin\Manager */
    public static $plugins;

    /** @var Config */
    public static $config;

    public static function Init() {
        //Load the easy ones
        self::$actions = new Actions();
        self::$filters = new Filters();
        self::$render = new Render();
        self::$config = new Config(ARTE_CONFIG_DIR);

        self::LoadPlugins();

    }

    protected static function LoadPlugins()
    {
        //Init Plugins
        $manager = new Pluggable\Plugin\Manager(
            new Pluggable\Plugin\Scanner(ARTE_PLUGIN_DIR),
            config_get_item('plugins', 'enabled', [])
        );
        $manager->initialise();
        self::$plugins = $manager;

        $manager->loadEnabled();
    }
}