<?php

namespace Apply\Library;

use Apply\Library\Support\Autoload;
use BadMethodCallException;
use Illuminate\Foundation\Application;

class Engine
{
    /**
     * All of the registered Library collect.
     *
     * @var array
     */
    public static $collections = [];

    /**
     * All of the registered Library tool plugins.
     *
     * @var array
     */
    public static $plugins = [];

    /**
     * Check if read PluginLoad
     *
     * $read boolean.
     */
    public static $read = false;

    /**
     * Get default element force.
     *
     * @return array
     */
    public static function plugin()
    {
        return static::$collections[config('library.default')]->collect(false);
    }

    /**
     * Register the given cube with library.
     *
     * @param $name
     * @param $collect
     * @return static
     */
    public static function collect($name, $collect = null)
    {
        if(!$collect){
            $name = $name ?? config('library.default');
            return static::$collections[$name];
        }

        static::$collections[$name] = $collect;

        return new static;
    }

    /**
     * Get all elements.
     *
     * @return array
     */
    public static function all()
    {
        return static::load();
    }

    /**
     * Load plugins cache.
     *
     * @return mixed
     */
    public static function load()
    {
        if (!static::$read){
            $load = new Load();
            static::$read = true;
            return static::$plugins = collect($load->items());
        }

        return static::$plugins;
    }

    /**
     * Generate structure element plug.
     *
     * @param $name
     * @param string $type
     * @return mixed
     */
    public function generate($name, $type = 'plugin')
    {
        return  static::$collections[$type]->generate($name);
    }

    /**
     * Run library engine
     *
     * @param Application $app
     * @return string
     */
    public static function run(Application $app)
    {
        $load = static::plugin();

        $items = $load->read()->filter(function ($item) {
            return $item->active == true;
        })->sortBy('order');

        // Register Class Composer
        foreach ($items as $element)
        {

            foreach ((array)$element->composer('autoload.psr-4') as $class => $src)
            {
                if (is_array($src)){
                    foreach ($src as $path){
                        Autoload::register($class, $element->path($path));
                    }
                }else {
                    Autoload::register($class, $element->path($src));
                }
            }

            if ($element->composer('autoload.files'))
                foreach ($element->composer('autoload.files') as $file){
                    require $element->path($file);
                }
        }

        foreach ($items as $element)
        {
            $method = $element->namespace('Apply\Setup');
            $app->register(new $method($app, $element));
        }
    }

    /**
     * Dynamically proxy static method calls.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return void
     */
    public static function __callStatic($method, $parameters)
    {
        if (! property_exists(get_called_class(), $method)) {
            throw new BadMethodCallException("Method {$method} does not exist.");
        }

        return static::${$method};
    }
}