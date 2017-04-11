<?php

if (php_sapi_name() == 'cli-server') {
    $info = parse_url($_SERVER['REQUEST_URI']);
    if (file_exists('./'.$info['path']) && is_file('./'.$info['path'])) {
        return false;
    }
}

define('ARTE_ROOT_DIR', __DIR__);

require 'vendor/autoload.php';
require 'library/include.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {

    $r->addRoute('GET', '/', function() {
        header('Content-Type: text/plain');

        $scanner = new \Artemis\Pluggable\Plugin\Scanner(ARTE_PLUGIN_DIR);
        $manager = new \Artemis\Pluggable\Plugin\Manager($scanner, []);
        $manager->initialise();

        var_dump($manager->getPlugins());

    });

});


$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

//strip query string
if (($qPos = strpos($uri, '?')) !== false) {
    $uri = substr($uri, 0, $qPos);
}

$route = $dispatcher->dispatch($httpMethod, $uri);
switch($route[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:

        header('Content-Type: text/plain', true, 404);
        echo '404 - Not Found';

        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:

        header('Content-Type: text/plain', true, 405);
        echo "405 - Method Not Allowed\nAllowed: ".join(", ", $route[1]);

        break;

    case FastRoute\Dispatcher::FOUND:

        $handler = $route[1];
        $vars = $route[2];
        call_user_func_array($handler, $vars);

        break;

}