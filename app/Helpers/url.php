<?php

function url(string $path = null): string
{
    $base = APP_URL;

    if ($path) {
        return $base . '/' . ltrim($path, '/');
    }

    return $base;
}

function assets(string $path = null): string
{
    $base = APP_URL . "/public/assets";

    if ($path) {
        return $base . '/' . ltrim($path, '/');
    }

    return $base;
}

function redirect(string $path): void
{
    header("Location: " . url($path));
    exit;
}
