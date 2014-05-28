<?php

class TrainController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	
    	$csrfToken = md5(Zend_Session::getId());
    	$general = new Zend_Session_Namespace('general');
    	$general->csrfToken = $csrfToken;
    	
    	$this->view->csrfToken = $csrfToken;
        
    }

    public function calculateAction()
    {
        // action body
        //$this->_helper->layout()->disableLayout();
    	//$this->_helper->viewRenderer->setNoRender(true);
        echo 'calculate';
    }
    
}

