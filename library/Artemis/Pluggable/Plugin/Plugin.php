<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 18/12/2016
 * Time: 01:14 PM
 */

namespace Artemis\Pluggable\Plugin;


use Artemis\Pluggable\Addon;

class Plugin extends Addon
{

    /**
     * @param array $info The plugin data
     * @return Plugin The converted plugin
     */
    public static function FromArray(array $info)
    {
        $plugin = new self();
        $plugin->PopulateFromArray($info);
        return $plugin;
    }
}