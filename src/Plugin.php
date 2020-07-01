<?php

namespace Apply\Library;

use Apply\Library\Drivers\Model;
use ArrayAccess;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use JsonSerializable;

class Plugin extends Model implements Arrayable, ArrayAccess, Jsonable, JsonSerializable, UrlRoutable
{
    use Concerns\HasArrayable,
        Concerns\HasArrayAccess,
        Concerns\HasActions,
        Concerns\HasAlias,
        Concerns\HasCollect,
        Concerns\HasComposer,
        Concerns\HasConfig,
        Concerns\HasJsonable,
        Concerns\HasLoad,
        Concerns\HasGenerate,
        Concerns\HasPath,
        Concerns\HasQuery,
        Concerns\HasMagic,
        Concerns\HasNamespace,
        Concerns\HasKey,
        Concerns\HasRoutable,
        Concerns\HasVendor;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates if the model exists.
     *
     * @var bool
     */
    public $exists = false;


    /**
     * Create a new Library plugin instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->syncOriginal();
    }

    /**
     * Create a new instance of the given plugin.
     *
     * @param  array  $attributes
     * @param  bool  $exists
     * @return static
     */
    public function newInstance($attributes = [], $exists = false)
    {
        $model = new static((array) $attributes);
        $model->exists = $exists;
        return $model;
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @return static
     */
    public function newFromBuilder($attributes = [])
    {
        $model = $this->newInstance([], true);
        $model->setRawAttributes((array) $attributes, true);
        return $model;
    }

    /**
     * Get a new query builder that doesn't have any global scopes or eager loading.
     *
     * @return Collection
     */
    public function newModelQuery()
    {
        return $this->newEloquentBuilder(
            $this->read()
        );
    }

    /**
     * Read the data from the engine.
     *
     * @param bool $instance
     * @return mixed
     */
    public function read($instance = true)
    {
        $items = [];

        foreach (Engine::all() as $plugin) {

            $item = $this->formatItem($plugin, $instance);

            !$this->collect
                ? ($items[] = $item)
                : ($plugin['type'] != $this->collect ?: $items[] = $item);
        }

        return new Collection($items);
    }

    /**
     * Format the data from item.
     *
     * @param $plugin
     * @param bool $instance
     * @return Plugin
     */
    public function formatItem($plugin, $instance = true)
    {
        $item =  $plugin['data'];
        $item['file'] = $plugin['file'];
        $item['composer'] = $plugin['composer'];

        if (array_key_exists('alias' , $item) && $item['alias'] == null){
            $item['alias'] = $item['type'].':'.$item['name'];
        }

        if (array_key_exists('core', $item) && $item['core']){
            $item['active'] = $item['core'];
        }

        return $instance ? $this->newFromBuilder($item) : $item;
    }


    /**
     * Handle dynamic method calls into the item.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->newQuery()->$method(...$parameters);
    }
}