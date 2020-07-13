<?php

namespace Apply\Library\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class LibraryMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'library:make {name} {--collect=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Element';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $collect = $this->option('collect') ?? config('library.default');

        $module = library()->generate($this->argument('name'), $collect);

        if ($module['status'] == 'error')
            $this->error($module['message']);

        elseif($module['status'] == 'success')
            $this->info($module['message']);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['collect', null, InputOption::VALUE_OPTIONAL, 'Generate a resource plugin for the given library.'],
        ];
    }
}
