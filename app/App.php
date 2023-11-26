<?php

namespace App;

use Illuminate\Support\Str;

class App
{
    /**
     * The Website version.
     *
     * @var string
     */
    private const VERSION = '1.0.0';

    /**
     * Get the current version of the Website.
     */
    public static function version(): string
    {
        return static::VERSION;
    }

    /**
     * Get the current API version, for extensions, of the website.
     */
    public static function apiVersion(): string
    {
        return Str::beforeLast(static::VERSION, '.');
    }
}