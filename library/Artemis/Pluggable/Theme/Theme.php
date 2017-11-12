<?php


namespace Artemis\Pluggable\Theme;


use Artemis\Pluggable\Addon;

class Theme extends Addon
{

    /**
     * @param array $info The plugin data
     * @return Theme The converted plugin
     */
    public static function FromArray(array $info)
    {
        $theme = new self();
        $theme->PopulateFromArray($info);
        return $theme;
    }
}