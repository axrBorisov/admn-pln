<?phpini_set('error_reporting', E_ALL);ini_set('display_errors', E_ALL);session_start();define('SITE_PATH', realpath(dirname(__FILE__)));include_once SITE_PATH . '/common/Autoloader.php';$autoloader = new Autoloader();$autoloader->addNamespace('common', SITE_PATH . '/common');$autoloader->addNamespace('controllers', SITE_PATH . '/controllers');$autoloader->addNamespace('models', SITE_PATH . '/models');$autoloader->addNamespace('services', SITE_PATH . '/services');$autoloader->register();Router::route(new Request());