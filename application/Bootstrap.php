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
		$config = new Zend_Config($this->getOptions());
		
		$db = Zend_Db::factory($config->resources->db->adapter , $config->resources->db->params );
		Zend_Db_Table::setDefaultAdapter($db);
		$db->query('SET names "utf8"');
		
		Zend_Registry::set('config', $config);
		return $config;
		
		
	}

	protected function _initAutoload()
	{
		$moduleLoader = new Zend_Application_Module_Autoloader(array(
			'namespace' => 'Ecmpc',
			'basePath' => APPLICATION_PATH));
		//$moduleLoader->addResourceType('Validator' , 'Validator' , 'Validator');
		return $moduleLoader;
	}
}

