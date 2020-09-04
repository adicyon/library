<?php

namespace Apply\Library;

use Apply\Library\Support\SplFileInfo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Finder\Finder;

class Load
{
    /**
     * $items array.
     */
    protected $items = [];

    /**
     * $changed boolean.
     */
    protected $changed = false;

    /**
     * Load constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Library load init.
     */
    public function init()
    {
        if (!Cache::has('apply.library'))
            $this->scan();

        $this->items = Cache::get('apply.library')['items'];
    }

    /**
     * Scan folder and generate item.
     */
    public function scan()
    {
        $files = Finder::create()->files()
            ->in(config("library.scan.folder"))
            ->name(config("library.scan.filename"))
            ->contains(null);

        $items = [];

        foreach ($files as $file) {
            $item = new SplFileInfo($file);
            $data = $this->generate($item);

            $items[$data['type'].':'.$data['name']] = $data;
        }

        $this->add($items)->save();

        return $this;
    }

    /**
     * Generate structure package item.
     * @param $file
     * @return mixed
     */
    public function generate($file)
    {
        $item = $file->getJsonDecode();

        $merge['id']   = $item['id'];
        $merge['name'] = $item['name'];
        $merge['type'] = $item['type'];
        $merge['data'] = $item;
        $merge['file'] = [
            'filename' => $file->getFilename(),
            'extension' => $file->getExtension(),
            'pathname' => $file->getPathname(),
            'path' => $file->getPathname(),
        ];

        $composer = new SplFileInfo($file->getPath().'/composer.json');
        $merge['composer'] = $composer->getJsonDecode();

        return $merge;
    }

    /**
     * Add items to packages and changed true.
     * @param $item
     * @return $this
     */
    public function add($item)
    {
        $this->items = $item;
        $this->changed = true;
        return $this;
    }

    /**
     * Update package and changed true.
     * @param $file
     * @return $this
     */
    public function update($file)
    {
        $item = new SplFileInfo($file);
        $data = $this->generate($item);

        $this->items[$data['type'].':'.$data['name']] = $data;
        $this->changed = true;
        $this->save();
        return $this;
    }

    /**
     * Remove an item from the library
     *
     * @param $collect
     * @param $name
     * @return void
     */
    public function remove($collect, $name)
    {
        Arr::forget($this->items, $collect.':'.$name);
        $this->changed = true;
        $this->save();
    }

    /**
     * Get items.
     */
    public function items()
    {
        return $this->items;
    }

    /**
     * Save packages on Cache.
     */
    public function save()
    {
        if ($this->changed) {
            Cache::forever('apply.library', ['items' => $this->items]);
            $this->changed = false;
        }
    }
}
