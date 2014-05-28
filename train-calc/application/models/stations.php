<?php

/**
 * stations
 * 
 * @author Asif
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

//class Model_stations extends Zend_Db_Table_Abstract {
class Model_stations{
	/**
	 * The default table name 
	 */
	protected $_name = 'stations';

	function loadAllStations(){
		
		//array(from,to,distance)
		$stations = array(
		    array(1,3,7),
		    array(1,2,1),
		    array(2,3,1),
		    array(2,4,2),
		    array(3,4,2)
		);
	
		return $stations;
	}
	
}

