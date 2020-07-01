<?php

namespace Apply\Library\Concerns;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

trait HasActions
{
    /**
     * Filesystem.
     */
    public function filesystem()
    {
        return new Filesystem;
    }

    /**
     * Write the data into the store.
     *
     * @param  array  $data
     * @return void
     */
    public function write(array $data)
    {
        $path = (array)$this->getAttribute('file');
        $data = Arr::except($data, ['file', 'composer']);

        if ($data) {
            $contents = json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        } else {
            $contents = '{}';
        }

        $this->filesystem()->put($path['pathname'], $contents);
        $this->load()->update($path['pathname']);
    }

    /**
     * enable Package.
     */
    public function enable()
    {
        if ($this->exists)
            $this->active = true;

        return $this->save();
    }

    /**
     * disable Package.
     */
    public function disable()
    {
        if ($this->exists)
            $this->active = false;

        return $this->save();
    }

    /**
     * Delete Package folder
     */
    public function delete()
    {
        if ($this->exists){
            $this->load()->remove($this->collect(), $this->getAttribute('name'));
            $this->filesystem()->deleteDirectory($this->path());
        }
    }

    /**
     * Save any changes done to the items data.
     *
     * @return mixed
     */
    public function save()
    {
        if ($this->exists)
            $this->write($this->getAttributes());
        return $this;
    }
}
