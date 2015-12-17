<?php
/**
 * Configuration file
 *
 * Configuration settings used globabbly
 *
 */

// Name of your site
$sitename = 'Mtc';

// Default language
$language = 'Nl';

// Default timezone used
define('DEFAULT_TIMEZONE', 'Europe/Brussels');

// Default charset of your site
define('CHARSET', 'UTF-8');

// Default Javascript, CSS and upload folder. If they do not exist, they will be created
define('FOLDER_JS', 'js');
define('FOLDER_CSS', 'css');
define('FOLDER_UPLOADS', 'uploads');

// Database settings
define('DB_NAME', 'mtc');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
define('DB_PORT', '');
define('DB_PREF', '');

// Base path, the absolute path of your project
if (substr($_SERVER['REMOTE_ADDR'],0,8) == "192.168.") {
  define('BASE_PATH', 'http://' . $_SERVER['SERVER_NAME'] . '/www/' . $sitename);
} else {
  define('BASE_PATH', 'http://' . $_SERVER['SERVER_NAME']);
}
define('SITE_NAME', $sitename);

// Default controller
define('DEFAULT_CONTROLLER', 'home');

// Others
define('DEVELOPMENT_ENVIRONMENT', true);
define('DEFAULT_LANGUAGE', $language);
?>
