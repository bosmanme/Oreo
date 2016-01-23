<?php
/**
 * Part of the BHive framework.
 *
 * @package    BHive
 * @version    1.0
 * @author     Mathias Bosman
 * @license    MIT License
 * @copyright  2016 - Mathias Bosman
 */

namespace BHive\Core;

/**
 * The File class contains several methods for handling files
 *
 * @package		BHive
 * @subpackage	Core
 */
class File
{
    /**
     * Returns the extension or false if none is present
     *
     * @see File::_getPathInfo()
     * @param   string  $path   The path of the file
     * @return  string|boolean
     */
    public static function extension($path)
    {
        return static::_getPathInfo($path, 'extension');
    }

    /**
     * Try to get a certain element of the native pathinfo() function
     *
     * @param   string  $file   The file to check
     * @param   string  $info   The info to return
     * @return  mixed
     */
    protected static function _getPathInfo($file, $info)
    {
            $pathInfo = pathinfo($file);
            if ( array_key_exists($info, $pathInfo)) {
                return $pathInfo['extension'];
            }
            
        return false;
    }
}
