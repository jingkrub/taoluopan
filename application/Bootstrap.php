<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

	protected function _initConfig()
	{
		Zend_Registry::set('config', new Zend_Config($this->getOptions()));		
	}
	
	protected function _initDatabases()
	{
	    $resource = $this->getPluginResource('db');
	    $db = $resource->getDbAdapter();
	    $db->query('SET names "utf8"');
// 	    Zend_Db_Table::setDefaultAdapter($db);
	}
	
	protected function _initDate()
	{
	    date_default_timezone_set(Zend_Registry::get('config')->settings->application->timezone);
	}

// 	protected function _initAutoload()
// 	{
// 		$moduleLoader = new Zend_Application_Module_Autoloader(array(
// 			'namespace' => 'Navo',
// 			'basePath' => APPLICATION_PATH));
// 		//$moduleLoader->addResourceType('Validator' , 'Validator' , 'Validator');
// 		return $moduleLoader;
// 	}
}

