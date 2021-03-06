<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 31/12/2016
 * Time: 06:18 PM
 */

namespace Artemis\Pluggable\Plugin;


class Manager
{
    /**
     * @var Scanner the scanner to use for plugins
     */
    private $scanner;
    /**
     * @var Plugin[]
     */
    private $plugins = [];
    /**
     * @var string[]
     */
    private $enabled = [];
    /**
     * @var Plugin[]
     */
    private $loaded = [];

    /**
     * Manager constructor.
     * @param Scanner $scanner the scanner to use for finding plugins
     * @param array $enabled names of the plugins to enable
     */
    public function __construct(Scanner $scanner, array $enabled)
    {
        $this->scanner = $scanner;
        $this->enabled = $enabled;
    }

    /**
     * Reads all plugin data, does not load plugins.
     */
    public function initialise()
    {
        $this->plugins = $this->scanner->FindAll();
    }

    /**
     * Loads enabled plugins from the loaded plugin list.
     * Ignores plugins already loaded.
     *
     * @return int Number of plugins loaded
     * @throws \Exception if enabled plugin not found
     */
    public function loadEnabled()
    {
        $loadCount = 0;
        foreach ($this->enabled as $name) {
            //Skip if already loaded
            if (array_key_exists($name, $this->loaded)) {
                continue;
            }
            //Error if not found
            if (!array_key_exists($name, $this->plugins)) {
                throw new \Exception('Enabled plugin ' . $name . ' could not be found');
            }
            //Load it
            $plugin = $this->plugins[$name];
            $plugin->load();
            $this->loaded[$name] = $plugin;
            $loadCount++;
        }
        return $loadCount;
    }

    //Getters

    /**
     * @return array
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * @return array
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return array
     */
    public function getLoaded()
    {
        return $this->loaded;
    }

    //Modifiers

    /**
     * Adds a new plugin to be loaded
     * @param Plugin $plugin
     */
    public function injectPlugin(Plugin $plugin)
    {
        $this->plugins[$plugin->name] = $plugin;
    }

    /**
     * Adds the named plugin to the enabled list, this doesn't load the plugin
     * @param string $name
     */
    public function enablePlugin($name)
    {
        if (!in_array($name, $this->enabled)) {
            $this->enabled[] = $name;
        }
    }

    /**
     * Adds the named plugins to the enabled list, this doesn't load the plugin
     * @param string[] $names
     */
    public function enablePlugins(array $names)
    {
        for ($i = 0; $i < count($names); $i++) {
            $this->enablePlugin($names[$i]);
        }
    }

    /**
     * Removes a plugin from the enabled list, this doesn't unload the plugin
     * @param string $name
     * @return bool
     */
    public function disablePlugin($name)
    {
        $i = array_search($name, $this->enabled);
        if ($i === false) {
            return false;
        }
        array_splice($this->enabled, $i, 1);
        return true;
    }

    //Info helpers

    public function isEnabled($name)
    {
        return in_array($name, $this->enabled);
    }

    public function isLoaded($name)
    {
        return array_key_exists($name, $this->loaded);
    }
}