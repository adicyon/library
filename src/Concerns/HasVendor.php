<?php

namespace Apply\Library\Concerns;

use Illuminate\Support\Str;

trait HasVendor
{
    /**
     *  vendor associated with the item.
     *
     * @param null $collect
     * @return string
     */
    public function vendor($collect = null)
    {
        $class = Str::of(class_basename($this))->snake()->plural();
        $collect = $this->config('vendor');
        return $collect ?? $class;
    }

}