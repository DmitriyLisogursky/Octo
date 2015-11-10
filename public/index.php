<?php
$env = (getenv('APPLICATION_ENV')) ? getenv('APPLICATION_ENV') : 'production';

define('ROOT_PATH', dirname(__DIR__));
define('IS_PRODUCTION', ($env == 'production'));
define('E_FATAL', E_ERROR | E_USER_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR);

if (!IS_PRODUCTION) {
    ini_set('error_reporting', E_ALL | E_STRICT);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    ini_set('error_reporting', 0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();