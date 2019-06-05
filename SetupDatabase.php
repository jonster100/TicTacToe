<?php
$server = "127.0.0.1";
$username = "root";//default for my localhost
$password = "";//default for my localhost
$databaseName = "tictactoeproject";

$connection = new mysqli($server,$username,$password);

// Check connection
if ($connection->connect_error == true) {
    die("Connection failed: " . $connection->connect_error);
} 
echo "Connected successfully</br>";

$createDatebase = "CREATE DATABASE " . $databaseName;

if($connection->query($createDatebase) == true) {
	echo "Database created!</br>";
} else {
	echo "Databse creation failed: " . $connection->error;
}

$connection = new mysqli($server,$username,$password, $databaseName);

$createMovesTable = "CREATE TABLE Moves (MoveId int, PlayerId varchar(12), XPosition int, YPosition int) ";

 if ($connection->query($createMovesTable)) {
     echo "Table created successfully";
} else {
    echo "Error creating table: " . $connection->error;
}

$connection = null;
?>