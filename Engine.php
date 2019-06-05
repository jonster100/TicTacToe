<?php
require "setupDatabase.php";

class Engine {
	private	$database;
	private $boardArray;
	private $currentPlayers;
	private $win = false;
	private $orderedMoves;
	function __construct() {
		$this->database = new Database();
		$this->orderedMoves=$this->database->getTableData();
		//print_r($this->orderedMoves);
		//echo sizeOf($this->orderedMoves);
		$this->boardArray = array(array(),array(),array());
		$this->currentPlayers = array("player1"=>"O","player2"=>"X");
		$this->fillBoard();
	}
	
	public function setBoardPosition($bool,$xPos,$yPos){
		if(($xPos>=0 && $xPos<=2) && ($yPos>=0 && $yPos<=2)){
			if($this->checkIfPositionFilled($xPos,$yPos)==false){
				$this->boardArray[$xPos][$yPos] = $this->currentPlayers[$bool];
				//echo $this->currentPlayers[$bool];
				$this->printBoard();
				echo "<p>" . $bool . " at position Xpos:" . $xPos . " Ypos:" . $yPos . " - Confirm = " . $this->boardArray[$xPos][$yPos] ."</p>";
				$this->database->insertTableData((is_null($this->orderedMoves))?0:end($this->orderedMoves)["MoveId"]+1,$bool,$xPos,$yPos);
				$this->orderedMoves=$this->database->getTableData();
				$this->win=$this->checkWinningConidtion();
			} else {
				echo "Position filled already try again!";
			}
		} else {
			echo "Setting Board Position Out of Bounds." . $bool . " At position X:" . $xPos . " Y:" . $yPos . "</br>";
		}
	}
	
	private function checkIfPositionFilled($xPos,$yPos){
		return ($this->boardArray[$xPos][$yPos]==null)?false:true;
	}
	
	private function fillBoard(){
		for($x=0;$x<3;$x++){
			for($y=0;$y<3;$y++){
				$this->boardArray[$x][$y]=null;
			}
		}
		if(is_null($this->orderedMoves)==false){
			echo "filling board";
			for($i=0;$i<sizeOf($this->orderedMoves);$i++){
				$this->boardArray[$this->orderedMoves[$i]["XPosition"]][$this->orderedMoves[$i]["YPosition"]] = $this->currentPlayers[$this->orderedMoves[$i]["PlayerId"]];
			}
		}
	}
	
	private function printBoard(){
		for($x=0;$x<3;$x++){
			echo "</br>";
			for($y=0;$y<3;$y++){
				echo ($this->boardArray[$x][$y]=="O")?$this->boardArray[$x][$y]:($this->boardArray[$x][$y]=="X")?$this->boardArray[$x][$y]:"-";
			}
		}
	}
	
	private function checkWinningConidtion(){
		//check rows
		$currentWinLength=0;
		for($x=0;$x<3;$x++){
			if((is_null($this->boardArray[0][$x])!=true) && ($this->boardArray[0][$x]==$this->boardArray[0][($x!=0)?$x-1:$x])){
				$currentWinLength+=1;
			}
			else {
				$currentWinLength=0;
			}
			if($currentWinLength==3){
				return $this->boardArray[0][$x];
			}
		}
		//check columns
		$currentWinLength=0;
		for($y=0;$y<3;$y++){
			if((is_null($this->boardArray[$y][0])!=true)&& ($this->boardArray[$y][0]==$this->boardArray[($y!=0)?$y-1:$y][0])){
				$currentWinLength+=1;
			}
			else {
				$currentWinLength=0;
			}
			if($currentWinLength==3){
				return $this->boardArray[$y][0];
			}
		}
		//check diagnal
		$currentWinLength=0;
		for($i=0;$i<3;$i++){
			if((is_null($this->boardArray[$i][$i])!=true)&& ($this->boardArray[$i][$i]==$this->boardArray[($i!=0)?$i-1:$i][($i!=0)?$i-1:$i])){
				$currentWinLength+=1;
			}
			else {
				$currentWinLength=0;
			}
			if($currentWinLength==3){
				return $this->boardArray[$i][$i];
			}
		}
		return false;
	}
	
	public function getWinner(){
		return $this->win;
	}
}
?>