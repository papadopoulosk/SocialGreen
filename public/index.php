<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));
define('APPLICATION_LIBRARY','../library');
set_include_path(implode(PATH_SEPARATOR, array(
APPLICATION_LIBRARY, get_include_path(),
)));

//exit(get_include_path());
//if ( file_exists(APPLICATION_LIBRARY . '/Zend/Loader/Autoloader.php') ) {
	//require_once('Zend/Filter/Word/CamelCaseToDash.php');
	//$zf_filter = new Zend_Filter_Word_CamelCaseToDash();
	//echo $zf_filter->filter('HelloWorld');
	// echos Hello-World
	
	require_once 'Zend/Loader/Autoloader.php';
	$autoloader = Zend_Loader_Autoloader::getInstance();
	//se ->setFallbackAutoloader(true);
//} else {
	//exit('The Zend library folder is missing!');
//}

/** Zend_Application */
//require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()->run();
