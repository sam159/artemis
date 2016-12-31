<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 18/12/2016
 * Time: 01:41 PM
 */

namespace Artemis\Pluggable\Plugin;


use RecursiveDirectoryIterator;
use RecursiveRegexIterator;

class Scanner
{
    public static function GetDefault() {
        return new self(ARTE_PLUGIN_DIR);
    }

    /**
     * @var
     */
    protected $dir;

    /**
     * PluginScanner constructor.
     * @param $dir
     * @throws \Exception If directory not found, Could not load plugin etc
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
        if (!is_dir($this->dir)) {
            throw new \Exception('Directory not found/readable');
        }
    }

    /**
     * Finds all plugin info files and converts them to a named array of plugin instances
     *
     * @return Plugin[]
     * @throws \Exception on duplicate plugins
     */
    public function FindAll() {
        $plugins = array_merge($this->FindJSON(), $this->FindPHP());
        $pluginMap = [];
        foreach($plugins as $p) {
            if (array_key_exists($p->name, $pluginMap)) {
                throw new \Exception('Duplicate plugin found. '.$p->name.' exists in "'.$p->rootDir.'" and "'.$pluginMap[$p->name]->rootDir.'"');
            }
            $pluginMap[$p->name] = $p;
        }
        return $pluginMap;
    }

    /**
     * @return Plugin[]
     */
    protected function FindJSON() {
        $pattern = '/plugin\.info\.json/i';

        $files = $this->Find($pattern);

        return array_map(array($this, 'ReadPlugin'), $files);
    }

    /**
     * @return Plugin[]
     */
    protected function FindPHP() {
        $pattern = '/plugin\.info\.php/i';

        $files = $this->Find($pattern);

        return array_map(array($this, 'ReadPlugin'), $files);
    }

    protected function Find($pattern) {
        $dirIter = new RecursiveDirectoryIterator($this->dir);
        $iter = new RecursiveRegexIterator($dirIter, $pattern);
        $files = [];
        foreach($iter as $file) {
            $files[] = $file;
        }
        return $files;
    }

    protected function ReadPlugin($file) {
        $result = include $file;
        return $this->Convert($result, $file);
    }

    protected function Convert($info, $path) {

        if ($info instanceof Plugin) {
            return $info;
        }

        if (is_string($info)) {
            //Convert json to array
            $info = json_decode($info, true);
        }

        if (is_array($info)) {
            //Convert array to plugin
            $plugin = Plugin::ConvertFromArray($info);
            if (empty($plugin->name)) {
                user_error('Plugin did not provide a name, using directory name', E_USER_WARNING);
                $plugin->name = basename(dirname($path));
            }
            $plugin->rootDir = dirname($path);
            return $plugin;
        }

        throw new \Exception('Invalid plugin data from '.$path);
    }

}