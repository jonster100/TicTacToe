<?php
class Database {
	private $server;
	private $username;
	private $password;
	private $databaseName; 
	private $connection;

	public function __construct(){
		$this->server  = "127.0.0.1";
		$this->username = "root";//default for my localhost
		$this->password = "";//default for my localhost
		$this->databaseName = "tictactoeproject";
		$this->connection = new mysqli($this->server,$this->username,$this->password);
		// Check connection
		if ($this->connection->connect_error == true) {
			die("Connection failed: " . $this->connection->connect_error);
		} else {
			echo "Connected successfully</br>";
		}
		$this->setupDatabase();
		$this->setupCurrentMovesTable();
		$this->setupRefLearnTable();
	}

	private function setupDatabase(){
		$createDatebase = "CREATE DATABASE " . $this->databaseName;
		if($this->connection->query($createDatebase) == true) {
			echo "Database created!</br>";
		} else {
			echo "Databse creation failed: " . $this->connection->error;
			$this->connection = new mysqli($this->server,$this->username,$this->password, $this->databaseName);
		}
	}

	private function setupCurrentMovesTable(){
		$this->connection = new mysqli($this->server,$this->username,$this->password, $this->databaseName);
		$createMovesTable = "CREATE TABLE CurrentMoves (MoveId int, PlayerId varchar(255), XPosition int, YPosition int)";
		if($this->connection->query($createMovesTable)) {
			echo "Table created successfully!</br>";
		} else {
			echo "Error creating table: " . $this->connection->error;
		}	
	}
	
	private function setupRefLearnTable(){
		$this->connection = new mysqli($this->server,$this->username,$this->password, $this->databaseName);
		$createMovesTable = "CREATE TABLE RefLearnMoves (MoveId int, PlayerId varchar(255), XPosition int, YPosition int, MoveOutcome smallint)";
		if($this->connection->query($createMovesTable)) {
			echo "Table created successfully!</br>";
		} else {
			echo "Error creating table: " . $this->connection->error;
		}	
	}
	
	public function insertCurrentMoveData($move,$player,$xPos,$yPos){
		$insetIntoTable = "INSERT INTO CurrentMoves (MoveId, PlayerId, XPosition, YPosition) VALUES ($move,'$player',$xPos,$yPos)";
		if ($this->connection->query($insetIntoTable)) {
			echo "Data inserte successfully!</br>";
		} else {
			echo "Error inserting data: " . $this->connection->error;
		}	
	}
	
	public function insertRefLearnData($move,$player,$xPos,$yPos, $moveO){
		$insetIntoTable = "INSERT INTO RefLearnMoves (MoveId, PlayerId, XPosition, YPosition, MoveOutcome) VALUES ($move,'$player',$xPos,$yPos,$moveO)";
		if ($this->connection->query($insetIntoTable)) {
			echo "Data inserte successfully!</br>";
		} else {
			echo "Error inserting data: " . $this->connection->error;
		}	
	}
	
	public function getTableData($getRefLearnData){
		$newDataArray = array();
		$getData = ($getRefLearnData==false)?"SELECT MoveId,PlayerId,XPosition,YPosition FROM CurrentMoves":"SELECT MoveId,PlayerId,XPosition,YPosition,MoveOutcome FROM RefLearnMoves";
		$data = $this->connection->query($getData);
		//echo "</br>" . $data->num_rows . "</br>";
		if($data->num_rows!=0){
			while($d = $data->fetch_assoc()){
				//print_r($d);
				array_push($newDataArray,$d);
			}
			echo "Loading Table Data!</br>";
			//print_r($newDataArray);
			return $newDataArray;
		} else {
			return null;
		}
	}
	
	public function delCurrentMoves(){
		$del = "DELETE FROM currentMoves";
		$this->connection->query($del);
	}

	public function closeConnection(){
		$this->connection = null;
	}
}
?>