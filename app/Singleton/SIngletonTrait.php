<?php

namespace App\Singleton;

trait SingletonTrait
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone() {}

    private function __wakeup() {}
}
