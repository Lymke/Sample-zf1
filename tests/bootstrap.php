<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
       APPLICATION_PATH . "/models",
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace("App_");

require_once 'Zend/Loader/Autoloader/Resource.php';
$resources = new Zend_Loader_Autoloader_Resource(array(
    'namespace' => 'App',
    'basePath' => APPLICATION_PATH
));

$resources->addResourceType('form','forms','Form');
$resources->addResourceType('model','models','Model');

//BDD
$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/db.ini',APPLICATION_ENV);
try {
    $db = Zend_Db::factory($config->resources->db);
    $db->query('SET NAMES UTF8');      // Pour mettre les donnees de la base en UTF-8
    $db->getConnection();
    Zend_Registry::set('db', $db);
    Zend_Db_Table_Abstract::setDefaultAdapter($db);
} catch (Exception $e) {
    exit($e->getMessage());
}
