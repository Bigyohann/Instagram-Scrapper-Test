<?php

namespace App\Utils;

use Illuminate\Support\Facades\Storage;

class FileScrapper
{
    public static function downloadFile(string $url, string $destinationFolder): string
    {
        if (!$stream = @fopen($url, 'r')) {
        }

        $tempFile = tempnam(sys_get_temp_dir(), 'post-file-');

        file_put_contents($tempFile, $stream);

        return Storage::putFile($destinationFolder, $tempFile);
    }
}
