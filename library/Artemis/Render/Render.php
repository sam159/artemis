<?php

namespace Artemis\Render;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Render
{
    /** @var FilesystemLoader */
    private $loader;
    /** @var Environment */
    private $twig;

    /**
     * Render constructor.
     */
    public function __construct()
    {
        $this->loader = new FilesystemLoader();
        $twig = $this->twig = new Environment($this->loader, [
            'cache' => pathjoin(ARTE_CACHE_DIR, 'twig'),
            'auto_reload' => true
        ]);

        $this->addNamespace(pathjoin(ARTE_LIBRARY_DIR, 'templates'), 'ARTE');
        $twig->addGlobal('Site', config_get('site'));

    }

    public function addNamespace($path, $namespace) {
        $this->loader->addPath($path, $namespace);
    }

    public function render($name, array $context) {
        return $this->twig->render($name, $context);
    }
}