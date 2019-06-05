<?php
class Database {
	private $server = "127.0.0.1";
	private $username = "root";//default for my localhost
	private $password = "";//default for my localhost
	private $databaseName = "tictactoeproject";
	private $connection;

	public function __construct(){
		$this->connection = new mysqli($this->server,$this->username,$this->password);
		// Check connection
		if ($this->connection->connect_error == true) {
			die("Connection failed: " . $this->connection->connect_error);
		} 
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
			$this->$connection = new mysqli($this->server,$this->username,$this->password, $this->databaseName);
		}
	}

	private function setupTable(){
		$this->$connection = new mysqli($this->server,$this->username,$this->password, $this->databaseName);
		$createMovesTable = "CREATE TABLE Moves (MoveId int, PlayerId varchar(12), XPosition int, YPosition int)";
		if ($connection->query($createMovesTable)) {
			echo "Table created successfully!</br>";
		} else {
			echo "Error creating table: " . $this->connection->error;
		}	
	}
	
	public function insertTableData($move,$player,$xPos,$yPos){
		$insetIntoTable = "INSERT INTO Moves (MoveId,PlayerId,XPosition,YPosition) VALUES ($move,$player,$xPos,$yPos)";
		if ($this->connection->query($insetIntoTable)) {
			echo "Data inserte successfully!</br>";
		} else {
			echo "Error inserting data: " . $this->connection->error;
		}	
	}
	
	public function getTableData(){
		
	}

	public function closeConnection(){
		$connection = null;
	}
}
?>