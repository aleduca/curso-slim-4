<?php

function render(string $view, array $data = [])
{
    $path = dirname(__FILE__, 2);
    $templates = new League\Plates\Engine($path . DIRECTORY_SEPARATOR . 'views');
    echo $templates->render($view, $data);
}
