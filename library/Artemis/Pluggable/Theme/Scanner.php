<?php


namespace Artemis\Pluggable\Theme;


class Scanner
{
    private $dir;

    /**
     * Scanner constructor.
     * @param $dir
     * @throws \Exception if dir is not valid
     */
    public function __construct($dir)
    {
        $this->dir = $dir;

        if (!is_dir($dir)) {
            throw new \Exception("Invalid theme directory");
        }
    }

    /**
     * @return Theme[]
     * @throws \Exception on duplicate theme or invalid theme info
     */
    public function FindAll()
    {
        $pattern = pathjoin($this->dir, '/*/theme.info.*');
        $themes = [];
        foreach (glob($pattern, GLOB_NOSORT) as $infoFile) {
            $theme = $this->ReadThemeInfo($infoFile);
            if (array_key_exists($theme->name, $themes)) {
                throw new \Exception("Duplicate theme: $theme->name");
            }
            $themes[$theme->name] = $theme;
        }
        return $themes;
    }

    /**
     * @param string $path
     * @return Theme
     * @throws \Exception on invalid theme info file
     */
    private function ReadThemeInfo($path)
    {
        $info = null;
        if (string_ends($path, '.php')) {
            $info = require $path;
        } else if (string_ends($path, '.json')) {
            $info = json_decode(file_get_contents($path), true);
        }
        if ($info instanceof Theme) {
            $info->rootDir = dirname($path);
            return $info;
        }
        if (is_array($info)) {
            $theme = Theme::FromArray($info);
            $theme->rootDir = dirname($path);
            return $theme;
        }
        throw new \Exception("$path does not contain valid theme date");
    }
}