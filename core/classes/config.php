<?php

class Config
{
    /**
	 * @var    array    $loadedFiles    array of loaded files
	 */
    public static $loadedFiles = [];

    /**
	 * @var    array    $items           the master config array
	 */
	protected static $items = array();

    /**
     * Load a config file into the settings
     * @param   string  $file       The file to load
     * @param   boolean $overwrite  Wether or not to overwrite existing settings
     */
    public static function load($file, $overwrite = false)
    {
        if ( ! $overwrite && array_key_exists($file, self::$loadedFiles)) {
            return;
        }

        $files = [];
        
        // First of all check if there's a core config file
        if (is_file(COREPATH . 'config' . DS . $file)) {
            $files[] = COREPATH . 'config' . DS . $file;
        }
        // Check if an app config is also present
        if (is_file(APPPATH . 'config' . DS . $file)) {
            $files[] = APPPATH . 'config' . DS . $file;
        }

        foreach ($files as $path) {
            if (is_file($path)) {
                $config = include($path);

                if (is_array($config)) {
                    foreach ($config as $item => $value) {
                        self::set($item, $value);
                    }
                }
            }
        }

        self::$loadedFiles[$file] = true;
    }

    /**
     * Set a specific setting
     * @param   string      $item       The setting
     * @param   mixed       $value      The value of the setting
     * @param   boolean     $overwrite  Wether or not to overwrite existing settings
     */
    public static function set($item, $value, $overwrite = true)
    {
        if ($overwrite || ! array_key_exists($item, static::$items)) {
            self::$items[$item] = $value;
        }
    }

    /**
     * Returns a config setting
     * @param   string  $item       name of the config item can be dot notated)
     * @param   mixed   $default    the reuturn vlue if the item is not found
     * @return  mixed
     */
    public static function get($item, $default = null)
    {
        if ( ! isset(static::$items[$item])) {
            return $default;
        } else {
            return self::$items[$item];
        }
    }
}
