<?php

namespace App\Core;

class Auth
{
    public static function user()
    {
        $session = new Session();
        return $session->auth ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function role(): ?string
    {
        $user = self::user();
        return $user->role ?? null;
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            flash("warning", "Você precisa fazer login.");
            redirect("/entrar");
        }
    }

    public static function requireRole(string $role): void
    {
        self::requireLogin();

        if (self::role() !== $role) {
            flash("error", "Acesso não autorizado.");
            redirect("/entrar");
        }
    }
}