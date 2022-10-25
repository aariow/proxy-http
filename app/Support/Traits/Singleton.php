<?php

namespace App\Support\Traits;

trait Singleton
{
    /**
     * Singleton instance
     *
     * @var static $_instance
     */
    protected static $_instance = null;

    /**
     * Get singleton instance.
     *
     * @return static
     */
    public static function getInstance(): static
    {
        if (is_null(static::$_instance)) {
            return static::$_instance = new static;
        }

        return static::$_instance;
    }
}