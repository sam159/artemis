<?php

namespace Artemis\Pluggable;

use Composer\Semver\VersionParser;

abstract class Addon
{
    /**
     * The unique name of the plugin
     * @var string
     */
    public $name = '';
    /**
     * The display name of the plugin
     * @var string
     */
    public $title = '';
    /**
     * @var array
     */
    public $authors = [];
    /**
     * @var string
     */
    public $url;
    /**
     * @var string Semantic Version
     * @see http://semver.org/ Versioning info
     */
    public $version;
    /**
     * @var string Name of license
     */
    public $license;
    /**
     * @var string Url location of license
     */
    public $licenseUrl;
    /**
     * @var string name of php file for loading plugin
     */
    public $entryPoint = 'plugin.php';

    //System Defined

    /**
     * @var string The location of the plugin
     */
    public $rootDir = '';

    public function load()
    {
        $entryPoint = pathjoin($this->rootDir, $this->entryPoint);
        if (file_exists($entryPoint)) {
            return require $entryPoint;
        }
        return false;
    }

    protected function PopulateFromArray(array $info)
    {
        //Read name
        $this->name = array_key_exists('name', $info) ? $info['name'] : '';
        //Read title
        $this->title = $this->name;
        if (array_key_exists('title', $info)) {
            $this->title = $info['title'];
        }
        //Read authors
        if (array_key_exists('authors', $info)) {
            foreach ($info['authors'] as $a) {
                $author = [];
                $author['name'] = array_key_exists('name', $a) ? $a['name'] : '';
                $author['email'] = array_key_exists('email', $a) ? $a['email'] : '';
                $author['url'] = array_key_exists('url', $a) ? $a['url'] : '';
            }
        }
        //Read url
        $this->url = array_key_exists('url', $info) ? $info['url'] : '';
        //Read version
        $version = array_key_exists('version', $info) ? $info['version'] : '';
        if (empty($version)) {
            $version = '1.0.0';
        }
        try {
            $version = VersionParser::parseStability($version);
        } catch (\UnexpectedValueException $ex) {
            $version = '1.0.0';
            user_error('Plugin ' . $this->name . ' did not provide a valid version number', E_USER_WARNING);
        }
        $this->version = $version;
        //Read license
        $this->license = array_key_exists('license', $info) ? $info['license'] : '';
        $this->licenseUrl = array_key_exists('license-url', $info) ? $info['license-url'] : '';

        //Read the entry point
        $this->entryPoint = array_key_exists('entry-point', $info) ? $info['entry-point'] : 'plugin.php';
    }
}