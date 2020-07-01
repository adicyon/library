<?php

namespace Apply\Library\Concerns;

use Illuminate\Config\Repository;
use Illuminate\Support\Str;

trait HasConfig
{
    /**
     * Config.
     *
     * @param null $key
     * @return Repository|mixed
     */
    public function config($key = null)
    {
        $config = 'library.'.$this->collect();
        return  $key ? config( $config.'.'.$key) : config( $config);
    }

}
