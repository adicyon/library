<?php

namespace Apply\Library\Concerns;

use Illuminate\Config\Repository;

trait HasComposer
{
    /**
     *  Composer associated with the item.
     *
     * @param null $key
     * @return Repository|mixed
     */
    public function composer($key = null)
    {
        $composer = new Repository($this->getAttribute('composer'));

        if ($key){
            return $composer->get($key);
        }

        return $composer;
    }

}
