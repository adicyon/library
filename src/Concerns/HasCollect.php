<?php

namespace Apply\Library\Concerns;

use Illuminate\Support\Str;

trait HasCollect
{
    /**
     * Collect plugins's.
     *
     * @var string
     */
    protected $collect;

    /**
     *  Collect associated with the plugin.
     *
     * @param null $collect
     * @return string
     */
    public function collect($collect = null)
    {
        if (is_null($collect)){

            $class = Str::snake(class_basename($this));
            $collect = $this->collect ?? null;
            return $driver ?? $class;

        } elseif (!$collect) {

            $this->collect = false;
        }

        $this->collect = $collect;
        return $this;
    }
}