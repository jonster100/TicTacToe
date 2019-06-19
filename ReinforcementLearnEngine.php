<?php

class RefLearnEngine {
	private $instanceId;
	private $instanceCostMap;
	
	function __construct(){
		$this->setupCostMap(null);
	}	
	
	private function setupCostMap($map){
		if(is_null($map)==true){
			$this->instanceCostMap = array(array(),array(),array());
		} else {
			for($x=0;x<sizeof($map);$x++){
				if(is_null($this->instanceCostMap[$map[$x]["XPosition"]][$map[$x]["YPosition"]])==true){
					$this->instanceCostMap[$map[$x]["XPosition"]][$map[$x]["YPosition"]]=$map[$x]["MoveOutcome"];
				} else {
					$this->instanceCostMap[$map[$x]["XPosition"]][$map[$x]["YPosition"]]+=$map[$x]["MoveOutcome"];
				}
			}
		}
	}
	
	public function move(){
		return rand(0,2);
	}
}

?>