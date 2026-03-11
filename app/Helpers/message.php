<?php

function flash(string $type, string $message): void
{
    $_SESSION['_flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function flash_message(): ?string
{
    if (!empty($_SESSION['_flash'])) {
        $flash = $_SESSION['_flash'];
        unset($_SESSION['_flash']);

        return "<div class='flash flash-{$flash['type']}'>{$flash['message']}</div>";
    }

    return null;
}
