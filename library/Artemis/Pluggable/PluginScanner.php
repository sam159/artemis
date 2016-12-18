<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 18/12/2016
 * Time: 01:41 PM
 */

namespace Artemis\Pluggable;


use RecursiveDirectoryIterator;
use RecursiveRegexIterator;

class PluginScanner
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
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
        if (!is_dir($this->dir)) {
            throw new \Exception('Directory not found/readable');
        }
    }

    public function FindAll() {
        return array_merge($this->FindJSON(), $this->FindPHP());
    }

    protected function FindJSON() {
        $pattern = '/plugin\.info\.json/i';

        $files = $this->Find($pattern);

        return array_map(array($this, 'Convert'), $files);
    }

    protected function FindPHP() {
        $pattern = '/plugin\.info\.php/i';

        $files = $this->Find($pattern);

        return array_map(array($this, 'Convert'), $files);
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

    protected function Convert($info) {

        if ($info instanceof Plugin) {
            return $info;
        }

        if (is_string($info)) {
            //Convert json to array
            $info = json_decode($info, true);
        }

        if (is_array($info)) {
            //Convert array to plugin

        }

    }

}