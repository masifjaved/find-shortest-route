<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	
	/**
     * Bootstrap autoloader for application resources
     * 
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload()
    {
    	 Zend_Loader_Autoloader::getInstance()->registerNamespace('mylib_');
    	
    }
    protected function _initAppAutoload(){
        $moduleLoad = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH
        ));

    }
	
	protected function _initSession() {
		Zend_Session::start();
	}

	protected function _initRoutes() {
		$frontController = Zend_Controller_Front::getInstance();
		$router = $frontController->getRouter();
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini','production');
		$router->addConfig($config,'routes');
	}

	protected function _initWildFire()
	{
		if (APPLICATION_ENV != 'development') return;

		$this->bootstrap('db');
		$db = Zend_Db_Table::getDefaultAdapter();

		$profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
		$profiler->setEnabled(true);
		$db->setProfiler($profiler);

		$writer = new Zend_Log_Writer_Firebug();
		$logger = new Zend_Log($writer);
		Zend_Registry::set('logger', $logger);
	}

	protected function _initView()
	{
		$view = new Zend_View($this->getOptions());
		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");

		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

		$view->jQuery()->setVersion('1.4.2')
						->enable()
						->setUiVersion('1.8.2');

		$view->doctype('XHTML1_STRICT');
		$view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
		$view->headTitle()->setSeparator(' - ');
		$view->headTitle('Train route calculator');
		$view->addHelperPath(APPLICATION_PATH.'/views/helpers/');

		return $view;
	}

        

}

