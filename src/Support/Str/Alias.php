<?php

namespace Apply\Library\Support\Str;

use Illuminate\Support\Str;

class Alias
{
    /**
     * @var $collect null
     */
    protected static $collect = null;

    /**
     * @var $plugin null
     */
    protected static $plugin = null;

    /**
     * Render Alias String
     *
     * @param $alias
     * @return mixed
     */
    public static function render($alias)
    {
        if (Str::contains($alias, ':')){
            $collection = Str::of($alias)->explode(':');
            static::$collect = $collection[0];
            static::$plugin = $collection[1];
        }
        else{
            static::$plugin = $alias;
        }

        return new static;
    }

    /**
     * Get collect
     *
     * @return mixed
     */
    public static function collect(){
        return static::$collect;
    }

    /**
     * Get plugin
     *
     * @return mixed
     */
    public static function plugin(){
        return static::$plugin;
    }
}