<?php

namespace Apply\Library\Support\Providers\Concerns;

trait HasConfigs
{
    /**
     * Register configs.
     */
    public function registerConfigs(): self
    {
        foreach ($this->configs() as $key => $value) {
           $this->mergeConfigFrom($value, $key);
        }

        return $this;
    }

    /**
     * Get the configs by the provider.
     *
     * @return array
     */
    public function configs(): array
    {
        return [];
    }

}
