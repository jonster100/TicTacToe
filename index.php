<?php 
	require "Engine.php";
	$testing = true;
	$engine = new Engine();
	if($testing==true){
		$engine->setBoardPosition("player1",0,0);
		$engine->setBoardPosition("player1",0,1);
		$engine->setBoardPosition("player1",0,2);
	}
	echo "The winner is " . $engine->getWinner() . "</b>";
?>

