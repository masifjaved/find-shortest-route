<?php

class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
	    if ($this->_isAjax()) {
		 header('Cache-Control: no-cache, must-revalidate');
		 header('Expires: Wed, 29 May 1974 12:50:00 GMT');
		 header('Content-type: application/json');
		}
	    $this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        // action body
        // session token check here xss csrf
        $status = true;
        $fileWithPath = 'testace';
        $results = array('status'=>$status, 'fileNameWithPath'=>$fileWithPath);
		echo json_encode($results);	
        
    }
    
    public function getshortestprouteAction(){
    	
    	$totalResults = array();
    	
    	if ($this->getRequest()->isPost()){
    		
    		$general = new Zend_Session_Namespace('general');
    		if ($this->_request->getParam('csrfToken') == $general->csrfToken){
    		
    		
		    	// I is the infinite distance.
				define('I',1000);
				
				// Size of the matrix
				$matrixWidth = 4;
				
				
				$stationsObj = new Model_stations();
				$points = $stationsObj->loadAllStations();
				$ourMap = array();
				
				
				// Read in the points and push them into the map
				
				for ($i=0,$m=count($points); $i<$m; $i++) {
				    $x = $points[$i][0];
				    $y = $points[$i][1];
				    $c = $points[$i][2];
				    $ourMap[$x][$y] = $c;
				    $ourMap[$y][$x] = $c;
				}
				
				// ensure that the distance from a node to itself is always zero
				// Purists may want to edit this bit out.
				
				for ($i=0; $i < $matrixWidth; $i++) {
				    for ($k=0; $k < $matrixWidth; $k++) {
				        if ($i == $k) $ourMap[$i][$k] = 0;
				    }
				}
				
				
				// initialize the algorithm class
				$sroute = new mylib_route($ourMap, I,$matrixWidth);
						
				$fromClass = $this->_request->getParam('stationA');
				$toClass = $this->_request->getParam('stationB');
				
				$sroute->findShortestPath($fromClass, $toClass);
				
				// Display the results	
					
				$results = $sroute->getResults((int)$toClass);
				foreach ($results as $result)
				{$totalResults[] = $result;}
				//var_dump(implode('-',$result['shortestpath']));
			} else { $totalResults = array( array('status'=>false,msg=>'CSRF Check Failure!')); }// csrfToken Check else
    	} else { $totalResults = array( array('status'=>false,msg=>'No Post')); } // no post else
			
    	echo json_encode($totalResults);	
    	
    	
    }
    
    function _isAjax() {
 		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}

    


}

