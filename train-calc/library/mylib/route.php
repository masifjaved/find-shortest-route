<?php
class mylib_route {

    var $visited = array();
    var $distance = array();
    var $previousNode = array();
    var $startnode =null;
    var $map = array();
    var $infiniteDistance = 0;
    var $numberOfNodes = 0;
    var $bestPath = 0;
    var $matrixWidth = 0;

    function mylib_route(&$ourMap, $infiniteDistance) {
        $this -> infiniteDistance = $infiniteDistance;
        $this -> map = &$ourMap;
        $this -> numberOfNodes = count($ourMap);
        $this -> bestPath = 0;
    }

    function findShortestPath($start,$to) {
        $this -> startnode = $start;
        for ($i=0;$i<$this -> numberOfNodes;$i++) {
            if ($i == $this -> startnode) {
                $this -> visited[$i] = true;
                $this -> distance[$i] = 0;
            } else {
                $this -> visited[$i] = false;
                $this -> distance[$i] = isset($this -> map[$this -> startnode][$i])
                    ? $this -> map[$this -> startnode][$i]
                    : $this -> infiniteDistance;
            }
            $this -> previousNode[$i] = $this -> startnode;
        }
        
        $maxTries = $this -> numberOfNodes;
        $tries = 0;
        while (in_array(false,$this -> visited,true) && $tries <= $maxTries) {            
            $this -> bestPath = $this->findBestPath($this->distance,array_keys($this -> visited,false,true));
            if($to !== null && $this -> bestPath === $to) {
                break;
            }
            $this -> updateDistanceAndPrevious($this -> bestPath);            
            $this -> visited[$this -> bestPath] = true;
            $tries++;
        }
    }

    function findBestPath($ourDistance, $ourNodesLeft) {
        $bestPath = $this -> infiniteDistance;
        $bestNode = 0;
        for ($i = 0,$m=count($ourNodesLeft); $i < $m; $i++) {
            if($ourDistance[$ourNodesLeft[$i]] < $bestPath) {
                $bestPath = $ourDistance[$ourNodesLeft[$i]];
                $bestNode = $ourNodesLeft[$i];
            }
        }
        return $bestNode;
    }

    function updateDistanceAndPrevious($obp) {        
        for ($i=0;$i<$this -> numberOfNodes;$i++) {
            if(     (isset($this->map[$obp][$i]))
                &&    (!($this->map[$obp][$i] == $this->infiniteDistance) || ($this->map[$obp][$i] == 0 ))    
                &&    (($this->distance[$obp] + $this->map[$obp][$i]) < $this -> distance[$i])
            )     
            {
                    $this -> distance[$i] = $this -> distance[$obp] + $this -> map[$obp][$i];
                    $this -> previousNode[$i] = $obp;
            }
        }
    }

 
    function getResults($to) {
        $ourShortestPath = array();
       $results = array();
        for ($i = 0; $i < $this -> numberOfNodes; $i++) {
            if($to !== null && $to !== $i) {
                continue;
            }
            $ourShortestPath[$i] = array();
            $endNode = null;
            $currNode = $i;
            $ourShortestPath[$i][] = $i;
            while ($endNode === null || $endNode != $this -> startnode) {
                $ourShortestPath[$i][] = $this -> previousNode[$currNode];
                $endNode = $this -> previousNode[$currNode];
                $currNode = $this -> previousNode[$currNode];
            }
            $ourShortestPath[$i] = array_reverse($ourShortestPath[$i]);
            if ($to === null || $to === $i) {
            if($this -> distance[$i] >= $this -> infiniteDistance) {
                $results[$i] = array("status"=>false,"msg"=> "no route", "shortestpath"=>"", "distance"=>"");
            } else {
              
                        $results[$i] = array("status"=>true,"msg"=> "route found", "shortestpath"=>$ourShortestPath[$i], "distance"=>$this->distance[$i]);
            }
            
                if ($to === $i) {
                    break;
                }
            }
        }
        return $results;
       
    }
} 