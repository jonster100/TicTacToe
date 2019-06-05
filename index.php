<?php 

	require "Engine.php";
	$testing = true;
	$engine = new Engine();
	//get data sent from index.html
	$dataObject = json_decode($_POST['jsonData']);
	if($testing==true){
		$engine->setBoardPosition($dataObject->playerId,$dataObject->xValue,$dataObject->yValue);
		//testing winning condition
		//$engine->setBoardPosition("player1",0,0);
		//$engine->setBoardPosition("player1",0,1);
		//$engine->setBoardPosition("player1",0,2);
	}
	echo "The winner is " . $engine->getWinner() . "</b>";
	
	//testing getting data from jquery2
	/*$dataObject = json_decode($_POST['jsonData']);
	echo $dataObject->xValue;*/
	
	
	//testing getting POST from JQuery form
	/*if ( isset( $_POST['submit'] ) ) { // retrieve the form data by using the element's name attributes value as key 
	$xPos = $_POST['xPos']; 
	$yPos = $_POST['yPos']; // display the results
	echo '<h3>Form POST Method</h3>'; 
	echo ' is ' . $xPos . ' ' . $yPos; 
	exit; 
	}*/
?>

