<?php 
class Zend_View_Helper_JavascriptHelper extends Zend_View_Helper_Abstract
{   
    function javascriptHelper($offset=NULL) {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $page = $request->getParam('page');
        if (empty($page)) {
        $file_uri = 'js/' . $request->getControllerName() . '/' . $request->getActionName() . '.js';
        $base_file_uri = 'js/' /*. $request->getControllerName() . '/' */. $request->getActionName() . '-base.js';
        } else {
            $file_uri = 'js/' . $page . '.js';
            $base_file_uri = 'js/' . $page . '-base.js';
        }
        $basePath =  Zend_Controller_Front::getInstance()->getBaseUrl().'/';
        $fullPath = $_SERVER['DOCUMENT_ROOT'].$basePath;
        if (file_exists($fullPath.$file_uri)) {
            if (is_null($offset))
                $this->view->headScript()->appendFile($basePath . $file_uri);
            else
                $this->view->headScript()->offsetSetFile('/' . $file_uri);
			
        }
	if (file_exists($base_file_uri)) $this->view->inlineScript()->appendFile('/' . $base_file_uri);
    }
}