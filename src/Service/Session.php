<?php

namespace App\Service;

class Session
{
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function flash($key)
    {
        $flash = $this->get($key);
        $this->remove($key);

        return $flash;
    }

    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }
    }

    public function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key)
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }
}
