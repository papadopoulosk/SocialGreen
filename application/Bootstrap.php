<?php
date_default_timezone_set('Europe/Athens');
if(!defined('BASE_PATH'))
{
	define('BASE_PATH', dirname(__FILE__) . '/..');
}


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initViewHelpers()
    {
        $view = new Zend_View();
        $view->headTitle('Sociallgreen')->setSeparator(' - ');
        
        //$this->_helper->redirector($action, $controller, $module, $params);
    }
}