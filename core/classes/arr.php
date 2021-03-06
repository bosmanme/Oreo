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
 * The Arr class provides a few nice functions for making
 * dealing with arrays easier
 *
 * @package		BHive
 * @subpackage	Core
 */
class Arr
{
    /**
	 * Gets a dot-notated key from an array, with a default value if it does
	 * not exist.
	 *
	 * @param   array   $array    The search array
	 * @param   mixed   $key      The dot-notated key or array of keys
	 * @param   string  $default  The default value
	 * @return  mixed
     */
    public static function get($array, $key, $default = null)
    {
        if ( ! is_array($array)) {
            return;
        }

        if (is_null($key)) {
            $return = [];

            foreach ($key as $k) {
                $return[$k] = static::get($array, $k, $default);
            }
            return $return;
        }

        is_object($key) && $key = (string) $key;

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        // Handle dot notation
        foreach (explode('.', $key) as $keyPart) {
            $array = $array[$keyPart];
        }

        return $array;
    }

    /**
     * Set an array item (dot-notated) to the value.
     *
     * @param   array   $array  The array to insert it into
     * @param   mixed   $key    The dot-notated key to set or array of keys
     * @param   mixed   $value  The value
     * @return  void
     */
    public static function set(&$array, $key, $value = null)
    {
        if (is_null($key)) {
            $array = $value;
            return;
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                static::set($array, $k, $v);
            }
        } else {
            $keys = explode('.', $key);

            while (count($keys) > 1) {
                $key = array_shift($keys);

                if ( ! isset($aray[$key]) || ! is_array($array[$key])) {
                    $array[$key] = [];
                }

                $array =& $array[$key];
            }

            $array[array_shift($keys)] = $value;
        }
    }

    /**
	 * Filters an array on prefixed associative keys.
	 *
	 * @param   array   the array to filter.
	 * @param   string  prefix to filter on.
	 * @param   bool    whether to remove the prefix.
	 * @return  array
	 */
	public static function filterPrefixed($array, $prefix, $removePrefix = true)
	{
		$return = array();
		foreach ($array as $key => $val)
		{
			if (preg_match('/^'.$prefix.'/', $key))
			{
				if ($removePrefix === true)
				{
					$key = preg_replace('/^'.$prefix.'/', '', $key);
				}
				$return[$key] = $val;
			}
		}
		return $return;
	}
}
