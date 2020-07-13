<?php

namespace Apply\Library\Support;

use Illuminate\Support\Facades\File;

class Helper
{
    public static function autoload($directory)
    {
        $helpers = File::glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            File::requireOnce($helper);
        }
    }
}
