<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 18/12/2016
 * Time: 01:14 PM
 */

namespace Artemis\Pluggable\Plugin;


use Composer\Semver\VersionParser;

class Plugin
{
    /**
     * @param array $info The plugin data
     * @return Plugin The converted plugin
     */
    public static function ConvertFromArray(array $info) {
        $plugin = new self();
        //Read name
        $plugin->name = array_key_exists('name', $info) ? $info['name'] : '';
        //Read authors
        if (array_key_exists('authors', $info)) {
            foreach($info['authors'] as $a) {
                $author = [];
                $author['name'] = array_key_exists('name', $a) ? $a['name'] : '';
                $author['email'] = array_key_exists('email', $a) ? $a['email'] : '';
                $author['url'] = array_key_exists('url', $a) ? $a['url'] : '';
            }
        }
        //Read url
        $plugin->url = array_key_exists('url', $info) ? $info['url'] : '';
        //Read version
        $version = array_key_exists('version', $info) ? $info['version'] : '';
        if (empty($version)) {
            $version = '1.0.0';
        }
        try {
            $version = VersionParser::parseStability($version);
        } catch (\UnexpectedValueException $ex) {
            $version = '1.0.0';
            user_error('Plugin '.$plugin->name.' did not provide a valid version number', E_USER_WARNING);
        }
        $plugin->version = $version;
        //Read license
        $plugin->license = array_key_exists('license', $info) ? $info['license'] : '';
        $plugin->licenseUrl = array_key_exists('licenseUrl', $info) ? $info['licenseUrl'] : '';

        //Read the entry point
        $plugin->entryPoint = array_key_exists('entryPoint', $info) ? $info['entryPoint'] : 'plugin.php';

        return $plugin;
    }

    //Author Defined

    /**
     * The Name of the plugin
     * @var string
     */
    public $name = '';
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

    public function load() {
        $entryPoint = pathjoin($this->rootDir, $this->entryPoint);
        if (file_exists($entryPoint)) {
            return require $entryPoint;
        }
        return false;
    }
}