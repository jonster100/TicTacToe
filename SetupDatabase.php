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
		$this->setupTable();
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

	private function setupTable(){
		$this->connection = new mysqli($this->server,$this->username,$this->password, $this->databaseName);
		$createMovesTable = "CREATE TABLE Moves (MoveId int, PlayerId varchar(255), XPosition int, YPosition int)";
		if($this->connection->query($createMovesTable)) {
			echo "Table created successfully!</br>";
		} else {
			echo "Error creating table: " . $this->connection->error;
		}	
	}
	
	public function insertTableData($move,$player,$xPos,$yPos){
		$insetIntoTable = "INSERT INTO Moves (MoveId, PlayerId, XPosition, YPosition) VALUES ($move,'$player',$xPos,$yPos)";
		if ($this->connection->query($insetIntoTable)) {
			echo "Data inserte successfully!</br>";
		} else {
			echo "Error inserting data: " . $this->connection->error;
		}	
	}
	
	public function getTableData(){
		$newDataArray = array();
		$getData = "SELECT MoveId,PlayerId,XPosition,YPosition FROM Moves";
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

	public function closeConnection(){
		$this->connection = null;
	}
}
?>