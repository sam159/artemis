<?php

namespace Artemis;

class Config
{

    private $configDir = false;
    private $loaded = [];

    /**
     * Config constructor.
     */
    public function __construct($configDir)
    {
        $this->configDir = $configDir;
    }

    /**
     * Gets the specified config.
     * @param string $name base file name
     * @return array|null
     */
    public function get($name) {
        if (array_key_exists($name, $this->loaded)) {
            return $this->loaded[$name];
        }

        $path = pathjoin($this->configDir, $name);

        $result = $this->readPath($path);
        if (is_array($result)) {
            return $this->loaded[$name] = filters_run('config::mutate', $result, $name);
        }
        return null;
    }

    protected function readPath($path) {
        $result = filters_run('config::load', null, $path, $this->configDir);
        if ($result !== null) {
            return $result;
        }
        if (is_file($path.'.json')) {
            return json_decode(file_get_contents($path.'.json'), true);
        }
        if (is_file($path.'.php')) {
            return require($path.'.php');
        }
        return false;
    }
}