<?php

function render_file($path, array $context) {
    $context = filters_run("render::context", $context, $path);

    return \Artemis\Arte::$render->render($path, $context);
}