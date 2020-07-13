<?php

namespace Apply\Library\Concerns;

trait HasAssets
{
    /**
     * Find asset file for theme asset.
     *
     * @param string    $path
     *
     * @return string
     */
    public function assets($path)
    {
        return route(config('library.assets.name'), [$this->alias, $path]);
    }
}
