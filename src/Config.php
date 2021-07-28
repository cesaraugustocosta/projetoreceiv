<?php

define("URL_BASE", 'https://localhost/receiv/cesar');

function redirect(?string $url)
{
    $location = URL_BASE . "/{$url}";
    header("HTTP/1.1 302 Redirect");
    header("Location: {$location}");
    exit;
}
