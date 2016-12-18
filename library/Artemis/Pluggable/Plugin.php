<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 18/12/2016
 * Time: 01:14 PM
 */

namespace Artemis\Pluggable;


class Plugin
{
    /**
     * The Name of the plugin
     * @var string
     */
    public $name = 'Unnamed';
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
}