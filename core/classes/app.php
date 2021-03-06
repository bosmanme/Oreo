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
 * The core of the framework
 *
 * @package		BHive
 * @subpackage	Core
 */
class App
{
	/**
	 * @var  string  The version number
	 */
	const VERSION = '1.0.0';

	/**
	 * @var  string  constant used for when in development
	 */
	const DEVELOPMENT = 'development';

	/**
	 * @var  string  constant used for when in production
	 */
	const PRODUCTION = 'production';

	/**
	 * @var  string  constant used for when testing the app in a staging env.
	 */
	const STAGING = 'staging';

	/**
	 * @var  boolean  Whether the framework has been initialized
	 */
	public static $initialized = false;

	protected static $_paths = [];

	/**
	 * @var  string  The Fuel environment
	 */
	public static $env = App::DEVELOPMENT;

	public static $locale = 'en_US';

	public static $timezone = 'UTC';

	public static $encoding = 'UTF-8';

	public static $name = '';

	/**
	 * Initializes the framework.  This can only be called once.
	 *
	 * @return	void
	 */
	public static function init($config)
	{
		if (static::$initialized) {
			return;
		}

		Config::load($config);

		static::$_paths = [APPPATH, COREPATH];
		static::$name = Config::get('app_name', '');
		static::$locale = Config::get('locale', static::$locale);
		static::$encoding = Config::get('encoding', static::$encoding);
		static::$timezone = Config::get('default_timezone') ?: date_default_timezone_get();
		date_default_timezone_set(static::$timezone);

		static::_setRepporting();

	}

	/**
     * Sets the error reporting level based on the environment
	 * @return void
     */
	protected static function _setRepporting()
	{
		if (self::$env == App::DEVELOPMENT) {
			error_reporting(E_ALL);
			ini_set("display_errors", 1);
		}
	}

    /**
     * Create new App class instance
     */
	public function __construct()
	{
		$this->_setRepporting();
		$this->_removeMagicQuotes();
		$this->_unregisterGlobals();
	}

	/**
	 * Strips slashes from a given variable
	 * @param  Mixed $value Either an array of other object
	 * @return Mixed
	 */
	private function _stripSlashesDeep($value)
	{
		$value = is_array($value) ? array_map([$this, 'stripSlashesDeep'], $value) : stripcslashes($value);

		return $value;
	}

	/**
	 * If get_magic_quotes is enabled, remove slashes from global variables
	 */
	private function _removeMagicQuotes()
	{
		if (get_magic_quotes_gpc()) {
			$_GET 		= $this->_stripSlashesDeep($_GET);
			$_POST 		= $this->_stripSlashesDeep($_POST);
			$_COOKIE	= $this->_stripSlashesDeep($_COOKIE);
		}
	}

	/**
	 * Just in case... (register globals was removed in php 5.4)
	 */
	private function _unregisterGlobals()
	{
		if (ini_get('register_globals')) {
			$array = [
				'_SESSION',
				'_POST',
				'_GET',
				'_COOKIE',
				'_REQUEST',
				'_SERVER',
				'_ENV',
				'_FILES'];

			foreach ($array as $value) {
				foreach ($GLOBALS[$value] as $key => $var) {
					if ($var === $GLOBALS[$key]) {
						unset($GLOBALS[$key]);
					}
				}
			}
		}
	}

	/**
	 * Includes the given file and returns the results.
	 *
	 * @param   string  the path to the file
	 * @return  mixed   the results of the include
	 */
	public static function load($file)
	{
		return include $file;
	}

	/**
	 * Cleans a file path so that it does not contain absolute file paths.
	 *
	 * @param   string  the filepath
	 * @return  string  the clean path
	 */
	public static function cleanPath($path)
	{
		// framework default paths
		static $search = array('\\', APPPATH, COREPATH, PKGPATH, DOCROOT);
		static $replace = array('/', 'APPPATH/', 'COREPATH/', 'PKGPATH/', 'DOCROOT/');

		// clean up and return it
		return str_ireplace($search, $replace, $path);
	}

}
