<?php

namespace App\Core;

class Session
{
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_save_path(__DIR__ . "/../../storage/sessions");
            session_start();
        }
    }

    public function __set(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function __get(string $name)
    {
        if (empty($_SESSION[$name])) {
            return null;
        }
        return $_SESSION[$name];
    }

    public function __isset(string $name): bool
    {
        return $this->has($name);
    }

    public function all(): ?object
    {
        return (object)$_SESSION;
    }

    public function set(string $key, mixed $value): self
    {
        $_SESSION[$key] = (is_array($value) ? (object)$value : $value);
        return $this;
    }

    public function unset(string $key): self
    {
        unset($_SESSION[$key]);
        return $this;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function regenerate(): self
    {
        session_regenerate_id(true);
        return $this;
    }

    public function destroy()
    {
        session_destroy();
        return $this;
    }
}