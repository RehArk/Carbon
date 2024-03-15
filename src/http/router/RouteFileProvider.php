<?php

namespace Rehark\Carbon\http\router;

/**
 * Class RouteFileProvider provides functionality to fetch route files from a directory.
 */
class RouteFileProvider {

    /**
     * Array to store paths of route files.
     * @var array
     */
    private array $files_paths;

    /**
     * Constructor for RouteFileProvider.
     * Initializes the files_paths array and fetches route files from the specified directory.
     * @param string $path The base directory path.
     */
    public function __construct(string $path) {
        $this->files_paths = [];
        $this->directoryIterator($path.'/'.'routes');
    }

    /**
     * Gets the array of route file paths.
     * @return array The array of route file paths.
     */
    public function get() : array {
        return $this->files_paths;
    }
    
    /**
     * Iterates through the directory recursively to fetch route files.
     * @param string $dir The directory path.
     */
    private function directoryIterator(string $dir) : void {

        foreach (new \DirectoryIterator($dir) as $file) {
      
            if($file == '.' || $file == '..') {
                continue;
            }
        
            if (!$file->isFile()) {
                $this->directoryIterator($dir.'/'.$file->getFilename());
                continue;
            }

            if ($file->getExtension() != 'php') {
                continue;
            }

            $this->dispatch($dir, $file->getFilename());
      
        }
      
    }

    /**
     * Dispatches the file path to be added to the files_paths array.
     * @param string $dir The directory path.
     * @param string $file The file name.
     */
    private function dispatch(string $dir, string $file) : void {
        $this->files_paths[] = $dir.'/'.$file;
    }

}