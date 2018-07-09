<?php
 
class Autoload
{
    static private $map         = array();
    static private $extensions  = array('.php', '.class.php');

    static public function add ($namespace, $dir) {
        if (is_dir($dir)) {
            self::$map[$namespace] = $dir;
            return true;
        }
        return false;
    }
    
    static protected function requireFile ($path) {
        foreach (self::$extensions as $ext) {
            if (file_exists($path . $ext)) {
                require_once $path . $ext;
                return true;
            }
        }
        return false;
    }
    
    static protected function register ($className) {
        $pathParts = explode('\\', $className);
        if (is_array($pathParts)) {
            $map = self::$map[array_shift($pathParts)];
            if (!empty($map)) {
                return self::requireFile($map . '/' . implode('/', $pathParts));
            }
        }
        return false;
    }
    
    static public function run () {
        spl_autoload_register(__NAMESPACE__ . '\\' . __CLASS__ . '::register');
    }
}

// separate autoload for Smarty classes
require_once __DIR__ . '/../vendor/smarty/libs/Autoloader.php';
Smarty_Autoloader::register();
