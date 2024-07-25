<?php

namespace Core;

class Session
{
    private $id;
    private $data;

    public function startSession()
    {
        session_start();
    }

    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    public function set(string $key, $value) {
        $_SESSION[$key] = $value;
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function getRole()
    {
        return $_SESSION['user_role'];
    }

    public function getUserId()
    {
        return $_SESSION['user_id'];
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }
}