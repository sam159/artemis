<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 10/11/2017
 * Time: 08:49 PM
 */

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


    }

    public function addNamespace($path, $namespace) {
        $this->loader->addPath($path, $namespace);
    }

    public function render($name, array $context) {
        return $this->twig->render($name, $context);
    }
}