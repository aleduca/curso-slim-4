<?php

use app\classes\Flash;

function getFlash(string $key)
{
    $flash = Flash::get($key);

    return isset($flash['message']) ? "<span class='alert alert-{$flash['alert']}'>{$flash['message']}</span>" : '';
}

function old(string $key)
{
    $flash = Flash::get('old_' . $key);

    return $flash['message'] ?? '';
}
