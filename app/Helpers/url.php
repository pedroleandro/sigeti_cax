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

function assets_sb_admin(string $path = null): string
{
    $base = APP_URL . "/resources/themes/startbootstrap-sb-admin-2-gh-pages";

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
