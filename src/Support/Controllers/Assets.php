<?php

namespace Apply\Library\Support\Controllers;

use Apply\Library\Support\Mimey\MimeTypes;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Assets
{
    /**
     * Serve the requested assets.
     *
     * @param string $package
     * @param string $path
     * @return BinaryFileResponse
     */
    public function __invoke(string $package, string $path)
    {
        $library = library()->plugin();

        $package = $library->where('alias', $package)->first();
        $realPath = $package->path('public/'.$path);

        $mime = new MimeTypes();
        $mime = $mime->getMimeType(File::extension($realPath));

        return response()->file($realPath, [
            'Content-Type'  => $mime ?? 'text/plain',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}