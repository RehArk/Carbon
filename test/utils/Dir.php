<?php

namespace Rehark\Carbon\Test\utils;

class Dir {

    public static function mk(string $path) {
        mkdir($path, 0777, true);
    }

    public static function rm(string $path) {
        $files = glob($path . '/*');

        foreach ($files as $file) {
            is_dir($file) ? Self::rm($file) : unlink($file);
        }

        rmdir($path);
    }

    public static function addFile(string $path, string $name, string $content) {
        $file = fopen($path. '/' . $name, 'w+');
        fwrite($file, $content);
        fclose($file);

    }
}