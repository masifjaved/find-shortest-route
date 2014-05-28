<?php
class Zend_View_Helper_CssHelper extends Zend_View_Helper_Abstract 
{ 
    function cssHelper($offset=NULL) { 
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $page = $request->getParam('page');
		
        if (empty($page))
            $file_uri = 'css/' . $request->getControllerName() . '/' . $request->getActionName() . '.css';
        else
    	    $file_uri = 'css/' . $page . '.css';
    	$basePath =  Zend_Controller_Front::getInstance()->getBaseUrl().'/';    
    	$fullPath = $_SERVER['DOCUMENT_ROOT'].$basePath;
    	     
        if (file_exists($fullPath . $file_uri)) {
                $this->view->headLink()->appendStylesheet($basePath . $file_uri,'screen',true, array('id' => 'page-style'));
  			
        }
    } 
}