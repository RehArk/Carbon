<?php

namespace carbon\kernel\loaders;

use \Exception;

/**
 * Auto loader with NameSpace
 * To auto include php file and class
 */
class Autoloader
{
	/**
	 * call this function when class loading
	 * @return void
	 */
	public static function register() : void
	{
		spl_autoload_register(array(__CLASS__,'load'));
	}
	
	/**
	 * load class file with relative path
	 * @var string $file
	 * @return void
	 */
	static function loadFile(string $file) : void
	{
		$path = BASE_DIR.$file.'.php';
		if(!file_exists($path)){
			throw new Exception($path.' : file not found');
		}
		include_once $path;
    }

	/**
	 * load class name with namespace
	 * @var string $class_name
	 * @return void
	 */
	static function loadClass($class_name) : void
	{
		if (!class_exists($class_name)) {	
			throw new Exception($class_name.' : class not found');
		}
	}
	
	/**
	 * include class file and load it
	 * @var string $class_name
	 * @return void
	 */
	static function load($class_name) : void
	{
		self::loadFile($class_name);
		self::loadClass($class_name);
	}
}

?>