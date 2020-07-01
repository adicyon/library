<?php
namespace Apply\Library\Console;

use Apply\Library\Support\Str\Alias;
use Illuminate\Console\GeneratorCommand as Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

abstract class GeneratorCommand extends Command
{
    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->getElement()->path(str_replace('\\', '/', 'src\\'.$name).'.php');
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->getElement()->namespace()."\\";
    }

    /**
     * Get the element library.
     *
     * @return mixed
     */
    protected function getElement()
    {
        $element = $this->option('plugin');
        $alias = Alias::render($element);
       return  library()->collect($alias::collect())->where('name',$alias::plugin())->first();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plugin', null, InputOption::VALUE_OPTIONAL, 'Plugin library.'],
        ];
    }
}
