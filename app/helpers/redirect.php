<?php

function redirect($response, $to, $status = 302)
{
    // return header("Location: {$to}");
    return $response->withHeader('location', $to)->withStatus($status);
}
