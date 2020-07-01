<?php

namespace Apply\Library\Concerns;

use Apply\Library\Load;

trait HasLoad
{
    /**
     * @return Load
     */
    public function load()
    {
        return new Load();
    }
}
