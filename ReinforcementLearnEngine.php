<?php

class RefLearnEngine {
	private $instanceId;
	private $instanceCostMap;
	private $allInstanceMoves;//an instance represents a game played till completion, this is a list of all the recorded moves with there outcome
	
	function __construct($moves){
		//print_r($moves);
		$this->instanceId=0;
		$this->allInstanceMoves=$moves;
		$this->setupCostMap();
		$this->instanceId=(is_null($this->allInstanceMoves))?0:end($this->allInstanceMoves)["MoveId"]+1;
	}
	
	private function setupCostMap(){
		$this->instanceCostMap = array(array(),array(),array());
		for($i=0;$i<3;$i++){
			for($o=0;$o<3;$o++){
				$this->instanceCostMap[$i][$o]=0;
			}
		}
		if(is_null($this->allInstanceMoves)==false){
			for($x=0;$x<sizeof($this->allInstanceMoves);$x++){
				$this->instanceCostMap[$this->allInstanceMoves[$x]["XPosition"]][$this->allInstanceMoves[$x]["YPosition"]]+=$this->allInstanceMoves[$x]["MoveOutcome"];
			}
		}
		$this->printBoard();
	}
	
	private	function printBoard(){
		for($x=0;$x<3;$x++){
			echo "</br>";
			for($y=0;$y<3;$y++){
				echo $this->instanceCostMap[$x][$y];
			}
		}
	}
	
	public function getInstanceId(){
		return $this->instanceId;
	}
	
	public function move($currentMoveMap){
		if(is_null($this->allInstanceMoves)==true){
			echo "</br>" . "RefLearn random pos";
			return array(rand(0,2),rand(0,2));
		} else {
			$tempX = array();
			$tempY = array();
			$highestWeight = array();
			for($x=0;$x<3;$x++){
				echo "</br>";
				for($y=0;$y<3;$y++){
					if(is_null($currentMoveMap[$x][$y])==true){
						$key = $x . $y;
						//echo "</br>" . "Added possible move!" . $key;
						$tempX[$key] = $x;
						$tempY[$key] = $y;
						$highestWeight[$key] = $this->instanceCostMap[$x][$y];
					}
				}
			}
			//print_r($tempX);
			//print_r($tempY);
			//print_r($highestWeight);
			asort($highestWeight);
			$keyArray = array_keys($highestWeight);
			$returnKey = end($keyArray);
			//echo "</br>" . $returnKey;
			//print_r(array($tempX[$returnKey],$tempY[$returnKey]));
			return array($tempX[$returnKey],$tempY[$returnKey]);
		}
	}
}

?>