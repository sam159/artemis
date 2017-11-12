<?php


namespace Artemis\Pluggable\Theme;


class Manager
{
    /**
     * @var Scanner
     */
    private $scanner;

    /**
     * @var Theme
     */
    private $currentTheme;

    /**
     * @var Theme[]
     */
    private $allThemes;

    /**
     * Manager constructor.
     * @param Scanner $scanner
     */
    public function __construct(Scanner $scanner)
    {
        $this->scanner = $scanner;
    }

    /**
     * @param string $currentThemeName
     */
    public function initialise($currentThemeName)
    {
        $this->allThemes = $this->scanner->FindAll();

        $this->setCurrentTheme($currentThemeName);
    }

    /**
     * @return Theme
     */
    public function getCurrentTheme()
    {
        return $this->currentTheme;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function setCurrentTheme($name)
    {
        if (array_key_exists($name, $this->allThemes)) {
            $this->currentTheme = $this->allThemes[$name];
        } else if (count($this->allThemes) > 0) {
            $this->currentTheme = reset($this->allThemes);
        } else {
            $this->currentTheme = null;
            return false;
        }
        return true;
    }

    /**
     * @return Theme[]
     */
    public function getAllThemes(): array
    {
        return $this->allThemes;
    }

}